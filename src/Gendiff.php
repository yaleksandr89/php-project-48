<?php

declare(strict_types=1);

namespace Gendiff;

use function Funct\Collection\sortBy;
use function Gendiff\Parsing\parseFile;

function genDiff(string $pathToFile1, string $pathToFile2): string
{
    $data1 = parseFile($pathToFile1);
    $data2 = parseFile($pathToFile2);

    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    $sortedKeys = sortBy($allKeys, fn($key) => $key);

    $lines = array_map(static function (string $key) use ($data1, $data2) {
        $inFirst = array_key_exists($key, $data1);
        $inSecond = array_key_exists($key, $data2);

        if ($inFirst && !$inSecond) {
            return "  - {$key}: " . toString($data1[$key]);
        }

        if (!$inFirst && $inSecond) {
            return "  + {$key}: " . toString($data2[$key]);
        }

        if ($inFirst && $inSecond && $data1[$key] !== $data2[$key]) {
            return "  - {$key}: " . toString($data1[$key]) . PHP_EOL
                . "  + {$key}: " . toString($data2[$key]);
        }

        return "    {$key}: " . toString($data1[$key]);
    }, $sortedKeys);

    return "{\n" . implode(PHP_EOL, $lines) . "\n}";
}

function toString(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if ($value === null) {
        return 'null';
    }

    return (string) $value;
}
