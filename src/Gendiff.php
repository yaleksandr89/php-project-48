<?php

declare(strict_types=1);

namespace Gendiff;

use Gendiff\Formatters\FormattersException;
use Gendiff\Parsing\ParseException;
use InvalidArgumentException;
use JsonException;

use function Gendiff\Differ\buildDiff;
use function Gendiff\Formatters\stylish;
use function Gendiff\Parsing\parseFile;

/**
 * @throws ParseException
 * @throws JsonException
 * @throws FormattersException
 */
function genDiff(string $path1, string $path2, string $format = 'stylish'): string
{
    $data1 = parseFile($path1);
    $data2 = parseFile($path2);

    $diff = buildDiff($data1, $data2);

    return match ($format) {
        'stylish' => stylish($diff),
        default => throw new InvalidArgumentException("Unsupported format: {$format}"),
    };
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
