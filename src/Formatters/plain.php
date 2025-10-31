<?php

declare(strict_types=1);

namespace Gendiff\Formatters;

/**
 * Plain formatter — отображает изменения в виде строк
 * @throws FormattersException
 */
function plain(array $diff): string
{
    $lines = buildPlain($diff);

    return implode("\n", $lines);
}

/**
 * Рекурсивная функция, формирующая строки plain-вывода.
 * @throws FormattersException
 */
function buildPlain(array $nodes, string $path = ''): array
{
    $lines = [];

    foreach ($nodes as $node) {
        $propertyPath = $path === '' ? $node['key'] : "{$path}.{$node['key']}";

        switch ($node['type']) {
            case 'added':
                $value = toStringValue($node['value']);
                $lines[] = "Property '{$propertyPath}' was added with value: {$value}";
                break;
            case 'removed':
                $lines[] = "Property '{$propertyPath}' was removed";
                break;
            case 'changed':
                $oldValue = toStringValue($node['oldValue']);
                $newValue = toStringValue($node['newValue']);
                $lines[] = "Property '{$propertyPath}' was updated. From {$oldValue} to {$newValue}";
                break;
            case 'nested':
                $lines = array_merge($lines, buildPlain($node['children'], $propertyPath));
                break;
            case 'unchanged':
                break;
            default:
                throw new FormattersException("Unknown node type: {$node['type']}");
        }
    }

    return $lines;
}

/**
 * Преобразует значения в текстовое представление для plain формата.
 */
function toStringValue(mixed $value): string
{
    return match (true) {
        is_array($value) => '[complex value]',
        is_bool($value) => $value ? 'true' : 'false',
        $value === null => 'null',
        is_string($value) => "'{$value}'",
        default => (string)$value,
    };
}
