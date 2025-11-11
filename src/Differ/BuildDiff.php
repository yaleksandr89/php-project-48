<?php

declare(strict_types=1);

namespace Differ\Differ;

function buildDiff(array $data1, array $data2): array
{
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($keys);

    return array_map(static function ($key) use ($data1, $data2) {
        $value1 = $data1[$key] ?? null;
        $value2 = $data2[$key] ?? null;

        $result = ['key' => $key];

        if (!array_key_exists($key, $data1)) {
            $result += ['type' => 'added', 'value' => $value2];
        } elseif (!array_key_exists($key, $data2)) {
            $result += ['type' => 'removed', 'value' => $value1];
        } elseif (is_array($value1) && is_array($value2)) {
            $result += ['type' => 'nested', 'children' => buildDiff($value1, $value2)];
        } elseif ($value1 !== $value2) {
            $result += ['type' => 'changed', 'oldValue' => $value1, 'newValue' => $value2];
        } else {
            $result += ['type' => 'unchanged', 'value' => $value1];
        }

        return $result;
    }, $keys);
}
