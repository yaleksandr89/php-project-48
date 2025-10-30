<?php

declare(strict_types=1);

namespace Gendiff\Tests;

use Gendiff\Parsing\ParseException;
use JsonException;
use PHPUnit\Framework\TestCase;

use function Gendiff\Parsing\parseFile;

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
}
