<?php

declare(strict_types=1);

namespace Differ\Differ;

use Differ\Exceptions\FormattersException;
use Differ\Exceptions\ParseException;
use JsonException;

use function Differ\Formatters\format;
use function Differ\Differ\readFile;
use function Differ\Parsing\parse;
use function Funct\Collection\sortBy;

/**
 * @throws ParseException
 * @throws JsonException
 * @throws FormattersException
 */
function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $file1 = readFile($pathToFile1);
    $file2 = readFile($pathToFile2);

    $data1 = parse($file1['content'], $file1['extension']);
    $data2 = parse($file2['content'], $file2['extension']);

    $diff = buildDiff($data1, $data2);

    return format($diff, $format);
}

function buildDiff(array $data1, array $data2): array
{
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    $sortedKeys = array_values(sortBy($keys, fn($key) => (string)$key));

    return array_map(static function ($key) use ($data1, $data2) {
        $value1 = $data1[$key] ?? null;
        $value2 = $data2[$key] ?? null;

        $result = ['key' => $key];

        if (!array_key_exists($key, $data1)) {
            $result += [
                'type' => 'added',
                'value' => $value2,
            ];
        } elseif (!array_key_exists($key, $data2)) {
            $result += [
                'type' => 'removed',
                'value' => $value1,
            ];
        } elseif (is_array($value1) && is_array($value2)) {
            $result += [
                'type' => 'nested',
                'children' => buildDiff($value1, $value2),
            ];
        } elseif ($value1 !== $value2) {
            $result += [
                'type' => 'changed',
                'oldValue' => $value1,
                'newValue' => $value2,
            ];
        } else {
            $result += [
                'type' => 'unchanged',
                'value' => $value1,
            ];
        }

        return $result;
    }, $sortedKeys);
}

function toString(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if ($value === null) {
        return 'null';
    }

    return (string)$value;
}
