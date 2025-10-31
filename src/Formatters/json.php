<?php

declare(strict_types=1);

namespace Gendiff\Formatters;

use JsonException;

/**
 * JSON formatter — выводит diff в виде JSON-строки.
 * @throws JsonException
 */
function json(array $diff): string
{
    return json_encode($diff, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
}
