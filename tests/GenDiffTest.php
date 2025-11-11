<?php

namespace Differ\Tests;

use Differ\Exceptions\ParseException;
use JsonException;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;

use function Differ\Differ\genDiff;
use function Differ\Differ\toString;
use function Differ\Parsing\parseFile;

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
        $ref = new ReflectionFunction('Differ\\Differ\\toString');
        $result = $ref->invoke(null);
        $this->assertSame('null', $result);
    }

    public function testToStringCoversAllBranches(): void
    {
        $this->assertSame('true', toString(true));
        $this->assertSame('false', toString(false));
        $this->assertSame('null', toString(null));
        $this->assertSame('123', toString(123));
        $this->assertSame('text', toString('text'));
    }
}
