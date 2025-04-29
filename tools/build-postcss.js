import fg from 'fast-glob';
import { promisify } from 'node:util';
import { exec } from 'node:child_process';

const run = promisify(exec);
const cssFiles = await fg('assets/css/src/*.css');

await Promise.all(
  cssFiles.map(async (file) => {
    const out = file.replace('/src/', '/dist/');        // src/main.css → dist/main.css
    await run(`postcss "${file}" -o "${out}"`);
    console.log(`✓ PostCSS → ${out.split('/').pop()}`);
  })
);
