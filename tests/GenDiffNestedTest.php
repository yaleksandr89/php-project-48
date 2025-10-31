<?php

namespace Gendiff\Tests;

use Gendiff\Formatters\FormattersException;
use Gendiff\Parsing\ParseException;
use JsonException;
use PHPUnit\Framework\TestCase;

use function Gendiff\Formatters\stylish;
use function Gendiff\genDiff;

class GenDiffNestedTest extends TestCase
{
    /**
     * @throws ParseException
     * @throws JsonException
     * @throws FormattersException
     */
    public function testJsonNestedDiff(): void
    {
        $file1 = __DIR__ . '/Fixtures/nested_file1.json';
        $file2 = __DIR__ . '/Fixtures/nested_file2.json';
        $expected = file_get_contents(__DIR__ . '/Fixtures/expected_stylish.txt');

        $this->assertSame($expected, genDiff($file1, $file2));
    }

    /**
     * @throws ParseException
     * @throws JsonException
     * @throws FormattersException
     */
    public function testYamlNestedDiff(): void
    {
        $file1 = __DIR__ . '/Fixtures/nested_file1.yml';
        $file2 = __DIR__ . '/Fixtures/nested_file2.yml';
        $expected = file_get_contents(__DIR__ . '/Fixtures/expected_stylish.txt');
        $this->assertSame($expected, genDiff($file1, $file2));
    }

    public function testStylishThrowsOnUnknownType(): void
    {
        $invalidDiff = [
            ['type' => 'unknown', 'key' => 'invalidKey', 'value' => 'test'],
        ];

        $this->expectException(FormattersException::class);
        stylish($invalidDiff);
    }

    /**
     * @throws FormattersException
     */
    public function testStylishHandlesDeeplyNestedArrays(): void
    {
        $diff = [
            [
                'type' => 'nested',
                'key' => 'level1',
                'children' => [
                    [
                        'type' => 'nested',
                        'key' => 'level2',
                        'children' => [
                            ['type' => 'added', 'key' => 'value', 'value' => 42],
                        ],
                    ],
                ],
            ],
        ];

        $result = stylish($diff);
        $this->assertStringContainsString('value: 42', $result);
    }
}
