<?php

declare(strict_types=1);

namespace Gendiff\Parsing;

use JsonException;
use Symfony\Component\Yaml\Yaml;

/**
 * @throws ParseException
 * @throws JsonException
 */
function parseFile(string $filePath): array
{
    $realPath = realpath($filePath);
    if ($realPath === false) {
        throw new ParseException('File not found: ' . $filePath);
    }

    $content = @file_get_contents($realPath);
    if ($content === false) {
        throw new ParseException('Cannot read file: ' . $filePath);
    }

    $ext = pathinfo($realPath, PATHINFO_EXTENSION);

    return match (strtolower($ext)) {
        'json' => json_decode($content, true, 512, JSON_THROW_ON_ERROR),
        'yaml', 'yml' => (array) Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new ParseException('Unsupported file format: ' . $ext),
    };
}
