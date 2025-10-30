<?php

declare(strict_types=1);

namespace Gendiff\Formatters;

/**
 * @throws FormattersException
 */
function stylish(array $diff, int $depth = 1): string
{
    $indent = str_repeat('    ', $depth - 1);

    $makeValue = static function (mixed $value, int $depth) use (&$makeValue): string {
        if (!is_array($value)) {
            return toString($value);
        }

        $innerIndent = str_repeat('    ', $depth);
        $closingIndent = str_repeat('    ', $depth - 1);
        $lines = [];

        foreach ($value as $k => $v) {
            $rendered = is_array($v) ? $makeValue($v, $depth + 1) : toString($v);
            $lines[] = $rendered === ''
                ? "{$innerIndent}    {$k}:"
                : "{$innerIndent}    {$k}: {$rendered}";
        }

        return "{\n" . implode("\n", $lines) . "\n{$closingIndent}    }";
    };

    $renderKV = static function (string $prefix, string $key, mixed $value, int $depth) use ($makeValue): string {
        $val = $makeValue($value, $depth);

        return $val === '' ? "{$prefix}{$key}:" : "{$prefix}{$key}: {$val}";
    };

    $lines = [];

    foreach ($diff as $node) {
        switch ($node['type']) {
            case 'added':
                $lines[] = $renderKV("{$indent}  + ", $node['key'], $node['value'], $depth);
                break;

            case 'removed':
                $lines[] = $renderKV("{$indent}  - ", $node['key'], $node['value'], $depth);
                break;

            case 'unchanged':
                $lines[] = $renderKV("{$indent}    ", $node['key'], $node['value'], $depth);
                break;

            case 'changed':
                $lines[] = $renderKV("{$indent}  - ", $node['key'], $node['oldValue'], $depth);
                $lines[] = $renderKV("{$indent}  + ", $node['key'], $node['newValue'], $depth);
                break;

            case 'nested':
                $children = stylish($node['children'], $depth + 1);
                $lines[] = "{$indent}    {$node['key']}: {$children}";
                break;

            default:
                throw new FormattersException("Unknown type: {$node['type']}");
        }
    }

    return "{\n" . implode("\n", $lines) . "\n{$indent}}";
}

function toString(mixed $value): string
{
    return match (true) {
        is_bool($value) => $value ? 'true' : 'false',
        $value === null => 'null',
        // пустая строка должна остаться пустой — это ключевой момент для "- wow:"
        default => (string)$value,
    };
}
