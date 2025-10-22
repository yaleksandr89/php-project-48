<?php

declare(strict_types=1);

namespace Gendiff\Parsing;

use JsonException;
use RuntimeException;

/**
 * @throws JsonException
 */
function parseFile(string $filePath): array
{
    $realPath = realpath($filePath);
    if ($realPath === false) {
        throw new \RuntimeException("File not found: {$filePath}");
    }

    $content = file_get_contents($realPath);
    if ($content === false) {
        throw new RuntimeException("Cannot read file: {$filePath}");
    }

    /** @var array|null $data */
    $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

    return $data ?? [];
}
