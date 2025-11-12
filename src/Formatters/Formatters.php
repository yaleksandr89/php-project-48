<?php

declare(strict_types=1);

namespace Differ\Formatters;

use Differ\Exceptions\FormattersException;
use JsonException;

use function Differ\Formatters\Stylish\render as renderStylish;
use function Differ\Formatters\Plain\render as renderPlain;
use function Differ\Formatters\Json\render as renderJson;

/**
 * @throws FormattersException
 * @throws JsonException
 */
function format(array $diff, string $format): string
{
    return match ($format) {
        'stylish' => renderStylish($diff),
        'plain'   => renderPlain($diff),
        'json'    => renderJson($diff),
        default   => throw new FormattersException("Unknown format: {$format}"),
    };
}
