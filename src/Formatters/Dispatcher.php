<?php

declare(strict_types=1);

namespace Differ\Formatters;

use Differ\Exceptions\FormattersException;
use JsonException;

/**
 * @throws FormattersException
 * @throws JsonException
 */
function format(array $diff, string $format): string
{
    return match ($format) {
        'stylish' => stylish($diff),
        'plain'   => plain($diff),
        'json'    => json($diff),
        default   => throw new FormattersException("Unknown format: {$format}"),
    };
}
