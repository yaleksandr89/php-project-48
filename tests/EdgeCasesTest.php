<?php

declare(strict_types=1);

namespace Differ\Tests;

use Differ\Exceptions\FormattersException;
use Differ\Exceptions\ParseException;
use JsonException;
use PHPUnit\Framework\TestCase;

use function Differ\Formatters\stylish;
use function Differ\Parsing\parseFile;

final class EdgeCasesTest extends TestCase
{
    /**
     * @throws JsonException
     */

    public function testParseFileThrowsOnFailedRead(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'gendiff_');
        unlink($path);
        mkdir($path);

        $this->expectException(ParseException::class);
        $this->expectExceptionMessage("Failed to read file");

        parseFile($path);

        rmdir($path);
    }

    /**
     * @throws JsonException
     */
    public function testParseFileThrowsOnYamlParseError(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'gendiff');
        file_put_contents($path, "key:\n  - : invalid_yaml");

        $this->expectException(ParseException::class);
        parseFile($path);

        unlink($path);
    }

    /**
     * @throws FormattersException
     */
    public function testStylishHandlesDeepNestedAndEmptyArrays(): void
    {
        $diff = [
            [
                'type' => 'nested',
                'key' => 'root',
                'children' => [
                    [
                        'type' => 'nested',
                        'key' => 'child',
                        'children' => [
                            [
                                'type' => 'added',
                                'key' => 'deep',
                                'value' => ['a' => [], 'b' => ['c' => 'd']],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $output = stylish($diff);
        $this->assertStringContainsString('deep', $output);
        $this->assertStringContainsString('c: d', $output);
    }

    /**
     * @throws JsonException
     */
    public function testParseFileUnsupportedExtension(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'gendiff_');
        file_put_contents($path, 'dummy');
        $renamed = $path . '.txt';
        rename($path, $renamed);

        $this->expectException(ParseException::class);
        $this->expectExceptionMessage('Unsupported format');

        parseFile($renamed);
        unlink($renamed);
    }

    /**
     * @throws JsonException
     */
    public function testParseFileThrowsYamlParseException(): void
    {
        $yaml = tempnam(sys_get_temp_dir(), 'gendiff_') . '.yml';
        file_put_contents($yaml, ":\n - bad yaml");

        $this->expectException(ParseException::class);
        parseFile($yaml);
        unlink($yaml);
    }
}
