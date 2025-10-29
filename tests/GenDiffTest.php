<?php

namespace Gendiff\Tests;

use Gendiff\Parsing\ParseException;
use JsonException;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;

use function Gendiff\genDiff;
use function Gendiff\Parsing\parseFile;

class GenDiffTest extends TestCase
{
    public function testFlatJsonDiff(): void
    {
        $file1 = __DIR__ . '/Fixtures/file1.json';
        $file2 = __DIR__ . '/Fixtures/file2.json';
        $expected = <<<EXPECTED
        {
          - follow: false
            host: hexlet.io
          - proxy: 123.234.53.22
          - timeout: 50
          + timeout: 20
          + verbose: true
        }
        EXPECTED;

        $this->assertSame($expected, genDiff($file1, $file2));
    }

    /**
     * @throws JsonException
     * @throws ParseException
     */
    public function testParseFileNotFound(): void
    {
        $this->expectException(ParseException::class);
        parseFile('nonexistent.json');
    }

    /**
     * @throws JsonException
     * @throws ParseException
     */
    public function testParseFileUnreadable(): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'gendiff_');
        chmod($tmp, 0000);
        $this->expectException(ParseException::class);
        parseFile($tmp);
        chmod($tmp, 0644);
        unlink($tmp);
    }

    public function testGenDiffIdenticalFiles(): void
    {
        $file = __DIR__ . '/Fixtures/file1.json';
        $expected = <<<EXPECTED
        {
            follow: false
            host: hexlet.io
            proxy: 123.234.53.22
            timeout: 50
        }
        EXPECTED;

        $this->assertSame($expected, genDiff($file, $file));
    }

    public function testToStringWithNullValue(): void
    {
        $ref = new ReflectionFunction('Gendiff\\toString');
        $result = $ref->invoke(null);
        $this->assertSame('null', $result);
    }
}
