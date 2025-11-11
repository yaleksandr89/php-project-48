<?php

declare(strict_types=1);

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

final class DifferTest extends TestCase
{
    public function testGenDiffStylish(): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/stylishExcepted.txt');
        $file1 = __DIR__ . '/Fixtures/file1.json';
        $file2 = __DIR__ . '/Fixtures/file2.json';

        $this->assertSame($expected, genDiff($file1, $file2, 'stylish'));
    }

    public function testGenDiffPlain(): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/plainExcepted.txt');
        $file1 = __DIR__ . '/Fixtures/file1.yml';
        $file2 = __DIR__ . '/Fixtures/file2.yml';

        $this->assertSame($expected, genDiff($file1, $file2, 'plain'));
    }

    public function testGenDiffJson(): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/jsonExcepted.txt');
        $file1 = __DIR__ . '/Fixtures/file1.json';
        $file2 = __DIR__ . '/Fixtures/file2.json';

        $this->assertSame($expected, genDiff($file1, $file2, 'json'));
    }
}
