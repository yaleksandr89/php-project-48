<?php

declare(strict_types=1);

namespace Differ\Differ;

use Differ\Exceptions\ParseException;

/**
 * @throws ParseException
 */
function readFile(string $path): array
{
    if (!file_exists($path)) {
        throw new ParseException("File '{$path}' does not exist");
    }

    $content = file_get_contents($path);
    if ($content === false) {
        throw new ParseException("Cannot read file '{$path}'");
    }

    $extension = pathinfo($path, PATHINFO_EXTENSION);

    return [
        'content' => $content,
        'extension' => $extension,
    ];
}
