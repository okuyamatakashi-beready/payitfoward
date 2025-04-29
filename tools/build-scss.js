// ESM モード (`type":"module"` が package.json に無い場合は require に書き換えてください)
import fg from 'fast-glob';
import { promisify } from 'node:util';
import { exec } from 'node:child_process';

const run = promisify(exec);
const scssFiles = await fg('assets/css/src/*.scss', { ignore: ['**/_*.scss'] });

await Promise.all(
  scssFiles.map(async (file) => {
    const out = file.replace('.scss', '.css');          // src/main.scss → src/main.css
    await run(`sass "${file}":"${out}" --no-source-map --style=compressed`);
    console.log(`✓ SCSS  → ${out.split('/').pop()}`);
  })
);
