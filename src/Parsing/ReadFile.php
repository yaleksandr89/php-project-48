<?php

declare(strict_types=1);

namespace Differ\Parsing;

use Differ\Exceptions\ParseException;

/**
 * @throws ParseException
 */
function readFile(string $path): string
{
    if (!file_exists($path)) {
        throw new ParseException("File '{$path}' does not exist");
    }

    $content = file_get_contents($path);
    if ($content === false) {
        throw new ParseException("Cannot read file '{$path}'");
    }

    return $content;
}
