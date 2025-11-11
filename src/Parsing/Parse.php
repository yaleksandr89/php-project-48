<?php

declare(strict_types=1);

namespace Differ\Parsing;

use Differ\Exceptions\ParseException;
use JsonException;
use Symfony\Component\Yaml\Yaml;

/**
 * @throws ParseException
 * @throws JsonException
 */
function parse(string $content, string $format): array
{
    return match ($format) {
        'json' => json_decode($content, true, 512, JSON_THROW_ON_ERROR),
        'yaml', 'yml' => Yaml::parse($content),
        default => throw new ParseException("Unknown format: {$format}")
    };
}
