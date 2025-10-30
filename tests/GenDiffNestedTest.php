<?php

namespace Gendiff\Tests;

use Gendiff\Parsing\ParseException;
use JsonException;
use PHPUnit\Framework\TestCase;

use function Gendiff\genDiff;

class GenDiffNestedTest extends TestCase
{
    /**
     * @throws ParseException
     * @throws JsonException
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
     */
    public function testYamlNestedDiff(): void
    {
        $file1 = __DIR__ . '/Fixtures/nested_file1.yml';
        $file2 = __DIR__ . '/Fixtures/nested_file2.yml';
        $expected = file_get_contents(__DIR__ . '/Fixtures/expected_stylish.txt');
        $this->assertSame($expected, genDiff($file1, $file2));
    }
}
