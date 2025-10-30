<?php

declare(strict_types=1);

namespace Gendiff\Differ;

function buildDiff(array $data1, array $data2): array
{
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($keys);

    return array_map(static function ($key) use ($data1, $data2) {
        $value1 = $data1[$key] ?? null;
        $value2 = $data2[$key] ?? null;

        if (!array_key_exists($key, $data1)) {
            return ['key' => $key, 'type' => 'added', 'value' => $value2];
        }

        if (!array_key_exists($key, $data2)) {
            return ['key' => $key, 'type' => 'removed', 'value' => $value1];
        }

        if (is_array($value1) && is_array($value2)) {
            return [
                'key' => $key,
                'type' => 'nested',
                'children' => buildDiff($value1, $value2)
            ];
        }

        if ($value1 !== $value2) {
            return [
                'key' => $key,
                'type' => 'changed',
                'oldValue' => $value1,
                'newValue' => $value2
            ];
        }

        return ['key' => $key, 'type' => 'unchanged', 'value' => $value1];
    }, $keys);
}
