<?php

declare(strict_types=1);

namespace Gendiff\Parsing;

use JsonException;
use Symfony\Component\Yaml\Yaml;
use Gendiff\Parsing\ParseException;

/**
 * Рекурсивно приводит stdClass к массивам.
 */
function normalize(mixed $value): mixed
{
    if (is_object($value)) {
        $value = get_object_vars($value);
    }

    if (is_array($value)) {
        $result = [];
        foreach ($value as $k => $v) {
            $result[$k] = normalize($v);
        }
        return $result;
    }

    return $value;
}


/**
 * @throws ParseException
 * @throws JsonException
 */
function parseFile(string $path): array
{
    if (!file_exists($path)) {
        throw new ParseException("File not found: {$path}");
    }

    if (!is_readable($path)) {
        throw new ParseException("File is not readable: {$path}");
    }

    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    $content = file_get_contents($path);
    if ($content === false) {
        throw new ParseException("Failed to read file: {$path}");
    }

    return match ($ext) {
        'json' => json_decode($content, true, 512, JSON_THROW_ON_ERROR),
        'yml', 'yaml' => (static function () use ($path) {
            try {
                $data = Yaml::parseFile($path, Yaml::PARSE_OBJECT_FOR_MAP);
            } catch (ParseException $e) {
                throw new ParseException($e->getMessage(), previous: $e);
            }
            return normalize($data);
        })(),
        default => throw new ParseException("Unsupported format: .{$ext}"),
    };
}
