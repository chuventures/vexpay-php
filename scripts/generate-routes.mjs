// Emits src/Generated/Routes.php — operationId → [method, path, success model] —
// from the SDK OpenAPI snapshot.
//
// Usage: node scripts/generate-routes.mjs <openapi.json> <Routes.php>
import { readFileSync, writeFileSync } from 'node:fs';

const [input, output] = process.argv.slice(2);
if (!input || !output) {
  console.error('usage: generate-routes.mjs <openapi.json> <Routes.php>');
  process.exit(2);
}

const METHODS = ['get', 'put', 'post', 'patch', 'delete'];
const doc = JSON.parse(readFileSync(input, 'utf8'));
const rows = [];
for (const [path, item] of Object.entries(doc.paths)) {
  for (const method of METHODS) {
    const op = item[method];
    if (!op?.operationId) continue;
    const success = Object.entries(op.responses ?? {})
      .filter(([code]) => /^2\d\d$/.test(code))
      .map(([, response]) => response.content?.['application/json']?.schema)
      .find(Boolean);
    const ref = success?.$ref ?? success?.items?.$ref;
    const model = ref ? ref.split('/').pop() : null;
    rows.push([op.operationId, method.toUpperCase(), path, model, success?.type === 'array']);
  }
}
rows.sort(([a], [b]) => (a < b ? -1 : a > b ? 1 : 0));

const lines = rows
  .map(([id, method, path, model]) => `        '${id}' => ['${method}', '${path}', ${model ? `'${model}'` : 'null'}],`)
  .join('\n');
const lists = rows
  .filter((row) => row[4])
  .map(([id]) => `        '${id}',`)
  .join('\n');

writeFileSync(
  output,
  `<?php

// Generated from packages/sdk-spec/openapi.json by scripts/generate-routes.mjs — do not edit.

declare(strict_types=1);

namespace VexPay\\Generated;

/**
 * @internal
 */
final class Routes
{
    /** @var array<string, array{0: string, 1: string, 2: ?string}> */
    public const ROUTES = [
${lines}
    ];

    /** Operations whose success body is a JSON array of the route's model. */
    public const LISTS = [
${lists}
    ];
}
`,
);
