<?php

declare(strict_types=1);

namespace Differ\Differ;

use Differ\Exceptions\FormattersException;
use Differ\Exceptions\ParseException;
use JsonException;

use function Differ\Formatters\format;
use function Differ\Parsing\parseFile;

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

    return format($diff, $format);
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
