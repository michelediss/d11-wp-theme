import fs from 'node:fs/promises';
import path from 'node:path';

export async function writeJsonFile(filePath, payload) {
  const outputPath = path.resolve(process.cwd(), filePath);
  await fs.mkdir(path.dirname(outputPath), { recursive: true });
  await fs.writeFile(outputPath, `${JSON.stringify(payload, null, 2)}\n`);
  return outputPath;
}

export async function readJsonFile(filePath) {
  const inputPath = path.resolve(process.cwd(), filePath);
  const raw = await fs.readFile(inputPath, 'utf8');
  return {
    path: inputPath,
    data: JSON.parse(raw),
  };
}
