<?php

declare(strict_types=1);

namespace Differ\Tests;

use Differ\Exceptions\ParseException;
use JsonException;
use PHPUnit\Framework\TestCase;

use function Differ\Parsing\parseFile;

class ParseFileTest extends TestCase
{
    /**
     * @throws JsonException
     */
    public function testParseFileNotFound(): void
    {
        $this->expectException(ParseException::class);
        parseFile('/tmp/not_exists_123456.json');
    }

    /**
     * @throws JsonException
     */
    public function testParseFileReadFailure(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'test_parse_');
        chmod($path, 0000);

        $this->expectException(ParseException::class);
        parseFile($path);

        chmod($path, 0644);
        unlink($path);
    }

    /**
     * @throws JsonException
     */
    public function testYamlParseError(): void
    {
        $invalidFile = tempnam(sys_get_temp_dir(), 'invalid_yaml_');
        file_put_contents($invalidFile, "::::invalid::::");

        $this->expectException(ParseException::class);
        parseFile($invalidFile);

        unlink($invalidFile);
    }

    /**
     * @throws JsonException
     */
    public function testParseFileThrowsWhenFileNotReadable(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'test');
        chmod($file, 0000);

        $this->expectException(ParseException::class);
        parseFile($file);

        unlink($file);
    }

    /**
     * @throws JsonException
     */
    public function testParseFileThrowsWhenYamlInvalid(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($file, ":\n  invalid_yaml");

        $this->expectException(ParseException::class);
        parseFile($file);

        unlink($file);
    }
}
