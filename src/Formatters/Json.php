<?php

declare(strict_types=1);

namespace Differ\Formatters\Json;

use JsonException;

/**
 * JSON formatter — выводит diff в виде JSON-строки.
 * @throws JsonException
 */
function render(array $diff): string
{
    return json_encode($diff, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
}
