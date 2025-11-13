<?php

declare(strict_types=1);

namespace Differ\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

final class DifferTest extends TestCase
{
    public static function providerFiles(): array
    {
        return [
            'json_files' => [
                self::getFixturePath('file1.json'),
                self::getFixturePath('file2.json'),
            ],
            'yml_files' => [
                self::getFixturePath('file1.yml'),
                self::getFixturePath('file2.yml'),
            ],
        ];
    }

    private static function getFixturePath(string $filename): string
    {
        return __DIR__ . "/Fixtures/{$filename}";
    }

    #[DataProvider('providerFiles')]
    public function testDefault(string $file1, string $file2): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/stylishExcepted.txt');

        $this->assertSame($expected, genDiff($file1, $file2));
    }

    #[DataProvider('providerFiles')]
    public function testStylish(string $file1, string $file2): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/stylishExcepted.txt');

        $this->assertSame($expected, genDiff($file1, $file2, 'stylish'));
    }

    #[DataProvider('providerFiles')]
    public function testPlain(string $file1, string $file2): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/plainExcepted.txt');

        $this->assertSame($expected, genDiff($file1, $file2, 'plain'));
    }

    #[DataProvider('providerFiles')]
    public function testJson(string $file1, string $file2): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/jsonExcepted.txt');

        $this->assertSame($expected, genDiff($file1, $file2, 'json'));
    }
}
