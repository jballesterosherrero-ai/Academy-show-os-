"use strict";

const Client = require("ssh2-sftp-client");
const crypto = require("node:crypto");
const fs = require("node:fs");
const path = require("node:path");
const posix = require("node:path").posix;

const HOST = "access-5021514183.webspace-host.com";
const PORT = 22;

// Huellas SHA-256 oficiales publicadas por IONOS para sus servidores Web Hosting.
// Se calcula SHA-256 directamente sobre la clave pública SSH recibida.
const IONOS_HOST_KEY_FINGERPRINTS = new Set([
  "J4oM+B2g7zZWAI3DolXR1e4vdIMrGO301kEN14/slsQ", // ECDSA
  "psLDE8kfhoS9GWrc/GTrdlPvyKPcWcGZv2JxOCvwF3w", // RSA
  "1gx2w8Rtv3wCgi7Jh8myf/KVd72cRQbow03UP8P095Q", // ED25519
]);

function required(name) {
  const value = process.env[name];
  if (!value || !value.trim()) {
    throw new Error("Falta configurar el secreto de GitHub: " + name);
  }
  return value;
}

function remoteDirectory() {
  const raw = (process.env.IONOS_REMOTE_DIR || "").trim();\n  if (!raw) {\n    throw new Error("Falta la variable IONOS_REMOTE_DIR: indica el destino exacto del subdominio en IONOS.");\n  }
  if (!raw || raw.includes("..") || raw.includes("\0")) {
    throw new Error("IONOS_REMOTE_DIR no es una ruta válida.");
  }
  if (raw === "/") return "/";
  return "/" + raw.replace(/^\/+|\/+$/g, "");
}

async function main() {
  const username = required("IONOS_SFTP_USER");
  const password = required("IONOS_SFTP_PASSWORD");
  const remoteDir = remoteDirectory();

  if (!fs.existsSync("index.html")) {
    throw new Error("No se encontró index.html en la raíz del repositorio.");
  }

  const source = fs.readFileSync("index.html");
  const runId = String(process.env.GITHUB_RUN_ID || Date.now()).replace(/[^a-zA-Z0-9_-]/g, "");
  const remoteIndex = posix.join(remoteDir, "index.html");
  const remoteTemp = posix.join(remoteDir, ".index.html.showos-upload-" + runId);
  const remoteRollback = posix.join(remoteDir, ".index.html.showos-rollback-" + runId);

  const sftp = new Client("SHOW OS IONOS deployment");
  let connected = false;
  let oldIndexMoved = false;

  try {
    await sftp.connect({
      host: HOST,
      port: PORT,
      username,
      password,
      readyTimeout: 20000,
      keepaliveInterval: 10000,
      // Fail closed: no se acepta ninguna clave de servidor que no esté
      // incluida en la lista oficial de huellas publicadas por IONOS.
      hostVerifier: (hostKey) => {
        if (!Buffer.isBuffer(hostKey)) return false;
        const fingerprint = crypto.createHash("sha256").update(hostKey).digest("base64");
        return IONOS_HOST_KEY_FINGERPRINTS.has(fingerprint);
      },
    });
    connected = true;

    const dirInfo = await sftp.exists(remoteDir);
    if (!dirInfo || dirInfo !== "d") {
      throw new Error("No existe la carpeta remota o la cuenta no tiene permiso para acceder a ella.");
    }

    const existing = await sftp.exists(remoteIndex);
    if (existing) {
      const oldContents = await sftp.get(remoteIndex);
      const oldBuffer = Buffer.isBuffer(oldContents) ? oldContents : Buffer.from(oldContents);
      fs.mkdirSync("deploy-backup", { recursive: true });
      fs.writeFileSync(path.join("deploy-backup", "index.html"), oldBuffer);
      fs.appendFileSync(required("GITHUB_OUTPUT"), "had_existing=true\n");
    } else {
      fs.appendFileSync(required("GITHUB_OUTPUT"), "had_existing=false\n");
    }

    // Sube primero con nombre temporal; el index.html activo no se toca si
    // la transferencia inicial falla.
    await sftp.put(source, remoteTemp);

    if (existing) {
      await sftp.rename(remoteIndex, remoteRollback);
      oldIndexMoved = true;
    }

    try {
      await sftp.rename(remoteTemp, remoteIndex);
      const deployed = await sftp.get(remoteIndex);
      const deployedBuffer = Buffer.isBuffer(deployed) ? deployed : Buffer.from(deployed);
      const expectedHash = crypto.createHash("sha256").update(source).digest("hex");
      const actualHash = crypto.createHash("sha256").update(deployedBuffer).digest("hex");

      if (expectedHash !== actualHash) {
        throw new Error("La comprobación del archivo publicado no coincide.");
      }

      if (oldIndexMoved) {
        await sftp.delete(remoteRollback);
        oldIndexMoved = false;
      }

      console.log("Publicación verificada: " + remoteIndex);
      console.log("SHA-256: " + actualHash);
    } catch (deploymentError) {
      // Si falla el cambio o la verificación, devuelve el archivo anterior.
      const current = await sftp.exists(remoteIndex);
      if (current) await sftp.delete(remoteIndex);

      if (oldIndexMoved && await sftp.exists(remoteRollback)) {
        await sftp.rename(remoteRollback, remoteIndex);
        oldIndexMoved = false;
      }

      if (await sftp.exists(remoteTemp)) await sftp.delete(remoteTemp);
      throw deploymentError;
    }
  } finally {
    if (connected) {
      await sftp.end().catch(() => {});
    }
  }
}

main().catch((error) => {
  // No se imprimen variables de entorno ni credenciales.
  console.error("No se pudo publicar SHOW OS CAMPUS por SFTP.");
  console.error(error && error.message ? error.message : "Error desconocido.");
  process.exitCode = 1;
});
