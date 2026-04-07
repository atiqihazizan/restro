import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname, '..');
const dest = path.join(root, 'bundled', 'laravel');

const skipTopLevel = new Set([
  'node_modules',
  'dist-electron',
  '.git',
  'backup',
  'bundled',
  'runtime',
  'electron',
  'scripts',
  '.cursor',
]);

function rmrf(target) {
  if (!fs.existsSync(target)) {
    return;
  }
  fs.rmSync(target, { recursive: true, force: true });
}

function copyDir(src, dst) {
  const stat = fs.statSync(src);
  if (stat.isDirectory()) {
    fs.mkdirSync(dst, { recursive: true });
    for (const name of fs.readdirSync(src)) {
      copyDir(path.join(src, name), path.join(dst, name));
    }
    return;
  }
  fs.copyFileSync(src, dst);
}

rmrf(dest);
fs.mkdirSync(dest, { recursive: true });

for (const name of fs.readdirSync(root)) {
  if (skipTopLevel.has(name)) {
    continue;
  }
  copyDir(path.join(root, name), path.join(dest, name));
}
