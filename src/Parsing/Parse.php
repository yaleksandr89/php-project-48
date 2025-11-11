<?php

declare(strict_types=1);

namespace Differ\Parsing;

use Differ\Exceptions\ParseException;
use JsonException;
use Symfony\Component\Yaml\Exception\ParseException as YamlParseException;
use Symfony\Component\Yaml\Yaml;

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

    if (!is_file($path)) {
        throw new ParseException("Failed to read file: {$path}");
    }

    if (!is_readable($path)) {
        throw new ParseException("File is not readable: {$path}");
    }

    $content = @file_get_contents($path);
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    return match ($ext) {
        'json' => json_decode($content, true, 512, JSON_THROW_ON_ERROR),
        'yml', 'yaml' => (static function () use ($path) {
            try {
                $data = Yaml::parseFile($path, Yaml::PARSE_OBJECT_FOR_MAP);
            } catch (YamlParseException $e) {
                throw new ParseException(
                    "YAML parse error in {$path}: " . $e->getMessage(),
                    previous: $e
                );
            }
            return normalize($data);
        })(),
        default => throw new ParseException("Unsupported format: .{$ext}"),
    };
}
