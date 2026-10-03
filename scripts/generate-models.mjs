// Emits src/Generated/Models/*.php — one readonly model class per component schema and one
// backed enum per string-enum property — from the SDK OpenAPI snapshot.
//
// Usage: node scripts/generate-models.mjs <openapi.json> <Generated dir>
//
// Supports exactly the schema constructs the snapshot uses (objects, $ref, arrays, string
// enums, nullable, oneOf of primitives/arrays, free-form objects) and fails on anything else,
// so a new construct is a loud codegen error instead of a silently wrong model.
import { mkdirSync, readFileSync, rmSync, writeFileSync } from 'node:fs';
import { join } from 'node:path';

const [input, outDir] = process.argv.slice(2);
if (!input || !outDir) {
  console.error('usage: generate-models.mjs <openapi.json> <Generated dir>');
  process.exit(2);
}

const HEADER = '// Generated from packages/sdk-spec/openapi.json by scripts/generate-models.mjs — do not edit.';
const NAMESPACE = 'VexPay\\Generated\\Models';
const IDENTIFIER = /^[A-Za-z_][A-Za-z0-9_]*$/;
const RESERVED_PROPERTIES = new Set(['raw']);

const doc = JSON.parse(readFileSync(input, 'utf8'));
const schemas = doc.components?.schemas ?? {};
const names = Object.keys(schemas).sort(compare);

function compare(a, b) {
  return a < b ? -1 : a > b ? 1 : 0;
}

function fail(where, message) {
  throw new Error(`generate-models: ${where}: ${message}`);
}

function pascal(name) {
  return name.charAt(0).toUpperCase() + name.slice(1);
}

function refName(ref, where) {
  const prefix = '#/components/schemas/';
  if (!ref.startsWith(prefix)) fail(where, `unsupported $ref ${ref}`);
  const name = ref.slice(prefix.length);
  if (!schemas[name]) fail(where, `dangling $ref ${ref}`);
  return name;
}

function caseName(value, where) {
  const words = String(value)
    .split(/[^A-Za-z0-9]+/)
    .filter(Boolean)
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase());
  let name = words.join('');
  if (!name) fail(where, `cannot derive an enum case from ${JSON.stringify(value)}`);
  if (/^[0-9]/.test(name)) name = `V${name}`;
  return name;
}

function comment(text, indent) {
  if (!text) return '';
  const lines = String(text).replace(/\*\//g, '* /').split('\n');
  return `${indent}/**\n${lines.map((line) => `${indent} * ${line}`.trimEnd()).join('\n')}\n${indent} */\n`;
}

/** @type {Map<string, string[]>} enum class → values */
const enums = new Map();

function enumFor(owner, prop, values, where) {
  if (!values.every((value) => typeof value === 'string')) return null;
  const name = `${owner}${pascal(prop)}`;
  if (schemas[name]) fail(where, `enum name ${name} collides with a schema`);
  enums.set(name, values);
  return name;
}

/**
 * Resolves one property schema to its PHP type, phpdoc type and hydration expression.
 * `value` is the PHP expression reading the raw value.
 */
function resolve(owner, prop, schema, where) {
  if (schema.$ref) {
    const ref = refName(schema.$ref, where);
    return {
      php: ref,
      doc: ref,
      hydrate: (value) => `${ref}::fromArray(${value})`,
      object: true,
    };
  }
  if (schema.allOf || schema.anyOf || schema.not) fail(where, 'allOf/anyOf/not are not supported');
  if (schema.oneOf) {
    const parts = schema.oneOf.map((member) => {
      if (member.$ref || member.type === 'object') fail(where, 'oneOf with objects is not supported');
      return resolve(owner, prop, member, where);
    });
    const php = [...new Set(parts.map((part) => part.php))].join('|');
    const docType = [...new Set(parts.map((part) => part.doc))].join('|');
    return { php, doc: docType, hydrate: (value) => value };
  }
  switch (schema.type) {
    case 'string': {
      if (schema.enum) {
        const name = enumFor(owner, prop, schema.enum, where);
        return {
          php: `${name}|string`,
          doc: `${name}|string`,
          hydrate: (value) => `self::enumOrRaw(${name}::class, ${value})`,
        };
      }
      return { php: 'string', doc: 'string', hydrate: (value) => value };
    }
    case 'number':
      return { php: 'float', doc: 'float', hydrate: (value) => value };
    case 'integer':
      return { php: 'int', doc: 'int', hydrate: (value) => value };
    case 'boolean':
      return { php: 'bool', doc: 'bool', hydrate: (value) => value };
    case 'object':
      if (schema.properties) {
        return { php: 'array', doc: 'array<string, mixed>', hydrate: (value) => value };
      }
      if (schema.additionalProperties && typeof schema.additionalProperties === 'object') {
        const inner = resolve(owner, prop, schema.additionalProperties, where);
        if (inner.object) fail(where, 'maps of objects are not supported');
        return { php: 'array', doc: `array<string, ${inner.doc}>`, hydrate: (value) => value };
      }
      return { php: 'array', doc: 'array<string, mixed>', hydrate: (value) => value };
    case 'array': {
      if (!schema.items) fail(where, 'array without items');
      const items = schema.items;
      if (items.$ref) {
        const ref = refName(items.$ref, where);
        return {
          php: 'array',
          doc: `list<${ref}>`,
          hydrate: (value) => `self::listOf(${ref}::class, ${value})`,
        };
      }
      if (items.type === 'string' && items.enum) {
        const name = enumFor(owner, prop, items.enum, where);
        return {
          php: 'array',
          doc: `list<${name}|string>`,
          hydrate: (value) =>
            `array_map(static fn ($item) => self::enumOrRaw(${name}::class, $item), ${value})`,
        };
      }
      if (items.type === 'object' || items.oneOf) {
        return { php: 'array', doc: 'list<array<string, mixed>>', hydrate: (value) => value };
      }
      const inner = resolve(owner, prop, items, where);
      return { php: 'array', doc: `list<${inner.doc}>`, hydrate: (value) => value };
    }
    default:
      fail(where, `unsupported type ${JSON.stringify(schema.type)}`);
  }
}

function nullableType(php) {
  return php.includes('|') ? `${php}|null` : `?${php}`;
}

function emitModel(name) {
  const schema = schemas[name];
  const where = name;
  if (schema.type !== 'object') fail(where, `top-level schema must be an object, got ${schema.type}`);
  const required = new Set(schema.required ?? []);
  const props = Object.entries(schema.properties ?? {});

  const fields = props.map(([prop, propSchema]) => {
    const at = `${name}.${prop}`;
    if (!IDENTIFIER.test(prop)) fail(at, 'property name is not a valid PHP identifier');
    if (RESERVED_PROPERTIES.has(prop)) fail(at, 'property name is reserved by VexPay\\Model');
    const type = resolve(name, prop, propSchema, at);
    const isRequired = required.has(prop);
    const nullable = !isRequired || propSchema.nullable === true;
    return { prop, schema: propSchema, type, isRequired, nullable };
  });

  // Required parameters first: PHP deprecates optional-before-required.
  const ordered = [...fields.filter((f) => !f.nullable), ...fields.filter((f) => f.nullable)];

  const params = ordered
    .map((field) => {
      const php = field.nullable ? nullableType(field.type.php) : field.type.php;
      const docType = field.nullable ? `${field.type.doc}|null` : field.type.doc;
      const description = [field.schema.description, field.type.doc !== field.type.php ? `@var ${docType}` : '']
        .filter(Boolean)
        .join('\n\n');
      const suffix = field.nullable ? ' = null' : '';
      return `${comment(description, '        ')}        public readonly ${php} $${field.prop}${suffix},`;
    })
    .join('\n');

  const args = ordered
    .map((field) => {
      let read;
      if (!field.nullable) {
        read = field.type.hydrate(`self::required($data, '${field.prop}')`);
      } else if (field.type.hydrate('$v') === '$v') {
        read = `$data['${field.prop}'] ?? null`;
      } else {
        read = `isset($data['${field.prop}']) ? ${field.type.hydrate(`$data['${field.prop}']`)} : null`;
      }
      return `            ${field.prop}: ${read},`;
    })
    .join('\n');

  const constructor = ordered.length
    ? `    public function __construct(\n${params}\n    ) {\n    }\n\n`
    : '';
  const build = ordered.length ? `new self(\n${args}\n        )` : 'new self()';

  return `<?php

${HEADER}

declare(strict_types=1);

namespace ${NAMESPACE};

use VexPay\\Model;

${comment(schema.description, '')}final class ${name} extends Model
{
${constructor}    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return (${build})->withRaw($data);
    }
}
`;
}

function emitEnum(name, values) {
  const used = new Map();
  const cases = values
    .map((value) => {
      let caseId = caseName(value, `${name}=${value}`);
      const seen = used.get(caseId) ?? 0;
      used.set(caseId, seen + 1);
      if (seen) caseId = `${caseId}${seen + 1}`;
      return `    case ${caseId} = '${String(value).replace(/\\/g, '\\\\').replace(/'/g, "\\'")}';`;
    })
    .join('\n');
  return `<?php

${HEADER}

declare(strict_types=1);

namespace ${NAMESPACE};

enum ${name}: string
{
${cases}
}
`;
}

const modelsDir = join(outDir, 'Models');
const files = new Map();
for (const name of names) files.set(`${name}.php`, emitModel(name));
for (const [name, values] of [...enums.entries()].sort(([a], [b]) => compare(a, b))) {
  files.set(`${name}.php`, emitEnum(name, values));
}

rmSync(modelsDir, { recursive: true, force: true });
mkdirSync(modelsDir, { recursive: true });
for (const [file, contents] of files) writeFileSync(join(modelsDir, file), contents);
console.log(`generate-models: ${names.length} models, ${enums.size} enums`);
