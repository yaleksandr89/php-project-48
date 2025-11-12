<?php

declare(strict_types=1);

namespace Differ\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

final class DifferTest extends TestCase
{
    public static function providerDiffCases(): array
    {
        $fixtures = [
            'default' => file_get_contents(__DIR__ . '/Fixtures/stylishExcepted.txt'),
            'stylish' => file_get_contents(__DIR__ . '/Fixtures/stylishExcepted.txt'),
            'plain'   => file_get_contents(__DIR__ . '/Fixtures/plainExcepted.txt'),
            'json'    => file_get_contents(__DIR__ . '/Fixtures/jsonExcepted.txt'),
        ];

        $extensions = ['json', 'yml'];

        $cases = [];

        foreach (['default', 'stylish', 'plain', 'json'] as $format) {
            foreach ($extensions as $ext) {
                $cases["{$format}_{$ext}"] = [
                    $fixtures[$format],
                    self::getFixturePath("file1.{$ext}"),
                    self::getFixturePath("file2.{$ext}"),
                    $format,
                ];
            }
        }

        return $cases;
    }

    private static function getFixturePath(string $filename): string
    {
        return __DIR__ . "/Fixtures/{$filename}";
    }

    #[DataProvider('providerDiffCases')]
    public function testDiff(string $expected, string $file1, string $file2, string $format): void
    {
        if ($format === 'default') {
            $this->assertSame($expected, genDiff($file1, $file2));
        } else {
            $this->assertSame($expected, genDiff($file1, $file2, $format));
        }
    }
}
