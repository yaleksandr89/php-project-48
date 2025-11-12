<?php

declare(strict_types=1);

namespace Differ\Formatters\Stylish;

use Differ\Exceptions\FormattersException;

/**
 * @throws FormattersException
 */
function render(array $diff, int $depth = 1): string
{
    $indentUnit = '    ';
    $currentIndent = str_repeat($indentUnit, $depth - 1);

    $renderValue = static function (mixed $value, int $depth) use (&$renderValue, $indentUnit): string {
        if (!is_array($value)) {
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }
            if ($value === null) {
                return 'null';
            }
            return (string)$value;
        }

        $indent = str_repeat($indentUnit, $depth);
        $closingIndent = str_repeat($indentUnit, $depth - 1);
        $lines = [];
        foreach ($value as $k => $v) {
            $lines[] = "{$indent}{$k}: {$renderValue($v, $depth + 1)}";
        }

        return "{\n" . implode("\n", $lines) . "\n{$closingIndent}}";
    };

    $lines = [];

    foreach ($diff as $node) {
        $type = $node['type'] ?? '';
        $key = $node['key'] ?? '';
        switch ($type) {
            case 'added':
                $value = $renderValue($node['value'], $depth + 1);
                $lines[] = "{$currentIndent}  + {$key}: {$value}";
                break;

            case 'removed':
                $value = $renderValue($node['value'], $depth + 1);
                $lines[] = "{$currentIndent}  - {$key}: {$value}";
                break;

            case 'unchanged':
                $value = $renderValue($node['value'], $depth + 1);
                $lines[] = "{$currentIndent}    {$key}: {$value}";
                break;

            case 'nested':
                $children = render($node['children'], $depth + 1);
                $lines[] = "{$currentIndent}    {$key}: " . ltrim($children);
                break;

            case 'changed':
                $old = $renderValue($node['oldValue'], $depth + 1);
                $new = $renderValue($node['newValue'], $depth + 1);
                $lines[] = "{$currentIndent}  - {$key}: {$old}";
                $lines[] = "{$currentIndent}  + {$key}: {$new}";
                break;

            default:
                throw new FormattersException("Unknown node type: {$type}");
        }
    }

    return "{\n" . implode("\n", $lines) . "\n{$currentIndent}}";
}
