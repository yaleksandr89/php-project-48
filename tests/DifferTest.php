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
            'json_files' => ['file1.json', 'file2.json'],
            'yml_files'  => ['file1.yml',  'file2.yml'],
        ];
    }

    private static function fx(string $name): string
    {
        return __DIR__ . "/Fixtures/{$name}";
    }

    #[DataProvider('providerFiles')]
    public function testDefault(string $f1, string $f2): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/stylishExcepted.txt');

        $this->assertSame($expected, genDiff(self::fx($f1), self::fx($f2)));
    }

    #[DataProvider('providerFiles')]
    public function testStylish(string $f1, string $f2): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/stylishExcepted.txt');

        $this->assertSame($expected, genDiff(self::fx($f1), self::fx($f2), 'stylish'));
    }

    #[DataProvider('providerFiles')]
    public function testPlain(string $f1, string $f2): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/plainExcepted.txt');

        $this->assertSame($expected, genDiff(self::fx($f1), self::fx($f2), 'plain'));
    }

    #[DataProvider('providerFiles')]
    public function testJson(string $f1, string $f2): void
    {
        $expected = file_get_contents(__DIR__ . '/Fixtures/jsonExcepted.txt');

        $this->assertSame($expected, genDiff(self::fx($f1), self::fx($f2), 'json'));
    }
}
