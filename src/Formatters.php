<?php

declare(strict_types=1);

namespace Gendiff\Formatters;

/**
 * @throws FormattersException
 */
function format(array $diff, string $format): string
{
    return match ($format) {
        'stylish' => stylish($diff),
        'plain'   => plain($diff),
        default   => throw new FormattersException("Unknown format: {$format}"),
    };
}
