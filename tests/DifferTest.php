<?php

declare(strict_types=1);

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

final class DifferTest extends TestCase
{
    public function testGenDiffStylish(): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/expected_stylish.txt');
        $file1 = __DIR__ . '/Fixtures/nested_file1.json';
        $file2 = __DIR__ . '/Fixtures/nested_file2.json';

        $this->assertSame($expected, genDiff($file1, $file2, 'stylish'));
    }

    public function testGenDiffPlain(): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/expected_plain.txt');
        $file1 = __DIR__ . '/Fixtures/nested_file1.yml';
        $file2 = __DIR__ . '/Fixtures/nested_file2.yml';

        $this->assertSame($expected, genDiff($file1, $file2, 'plain'));
    }

    public function testGenDiffJson(): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/expected_json.txt');
        $file1 = __DIR__ . '/Fixtures/nested_file1.json';
        $file2 = __DIR__ . '/Fixtures/nested_file2.json';

        $this->assertSame($expected, genDiff($file1, $file2, 'json'));
    }
}
