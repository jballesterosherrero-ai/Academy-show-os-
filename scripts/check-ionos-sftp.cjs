"use strict";

const Client = require("ssh2-sftp-client");
const crypto = require("node:crypto");

const HOST = "access-5021514183.webspace-host.com";
const PORT = 22;

const IONOS_HOST_KEY_FINGERPRINTS = new Set([
  "J4oM+B2g7zZWAI3DolXR1e4vdIMrGO301kEN14/slsQ", // ECDSA
  "psLDE8kfhoS9GWrc/GTrdlPvyKPcWcGZv2JxOCvwF3w", // RSA
  "1gx2w8Rtv3wCgi7Jh8myf/KVd72cRQbow03UP8P095Q", // ED25519
]);

function remoteDirectory() {
  const raw = (process.env.IONOS_REMOTE_DIR || "/show-os-campus").trim();
  if (!raw || raw.includes("..") || raw.includes("\0")) {
    throw new Error("IONOS_REMOTE_DIR no es una ruta válida.");
  }
  if (raw === "/") return "/";
  return "/" + raw.replace(/^\/+|\/+$/g, "");
}

function required(name) {
  const value = process.env[name];
  if (!value || !value.trim()) {
    throw new Error("Falta configurar el secreto de GitHub: " + name);
  }
  return value;
}

async function main() {
  const username = required("IONOS_SFTP_USER");
  const password = required("IONOS_SFTP_PASSWORD");
  const directory = remoteDirectory();
  const sftp = new Client("SHOW OS IONOS preflight");
  let connected = false;

  try {
    await sftp.connect({
      host: HOST,
      port: PORT,
      username,
      password,
      readyTimeout: 20000,
      keepaliveInterval: 10000,
      hostVerifier: (hostKey) => {
        if (!Buffer.isBuffer(hostKey)) return false;
        const fingerprint = crypto.createHash("sha256").update(hostKey).digest("base64");
        return IONOS_HOST_KEY_FINGERPRINTS.has(fingerprint);
      },
    });
    connected = true;

    const directoryType = await sftp.exists(directory);
    if (directoryType !== "d") {
      throw new Error("La carpeta remota no existe o la cuenta SFTP no tiene acceso: " + directory);
    }

    const indexType = await sftp.exists(directory.replace(/\/+$/, "") + "/index.html");
    console.log("Conexión SFTP y huella IONOS: verificadas.");
    console.log("Carpeta de destino accesible: " + directory);
    console.log("index.html actual: " + (indexType ? "encontrado" : "todavía no existe"));
    console.log("Prueba de diagnóstico terminada. No se ha escrito ni modificado ningún archivo.");
  } finally {
    if (connected) await sftp.end().catch(() => {});
  }
}

main().catch((error) => {
  console.error("No se pudo completar la prueba de conexión SFTP.");
  console.error(error && error.message ? error.message : "Error desconocido.");
  process.exitCode = 1;
});
