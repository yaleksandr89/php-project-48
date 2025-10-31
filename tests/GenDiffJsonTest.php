<?php

declare(strict_types=1);

namespace Gendiff\Tests;

use Gendiff\Formatters\FormattersException;
use Gendiff\Parsing\ParseException;
use JsonException;
use PHPUnit\Framework\TestCase;

use function Gendiff\Formatters\json;
use function Gendiff\genDiff;

final class GenDiffJsonTest extends TestCase
{
    /**
     * @throws ParseException
     * @throws JsonException
     * @throws FormattersException
     */
    public function testJsonFormatterProducesValidJson(): void
    {
        $file1 = __DIR__ . '/Fixtures/nested_file1.json';
        $file2 = __DIR__ . '/Fixtures/nested_file2.json';

        $output = genDiff($file1, $file2, 'json');

        $decoded = json_decode($output, true, 512, JSON_THROW_ON_ERROR);

        $this->assertIsArray($decoded);
        $this->assertArrayHasKey('key', $decoded[0]);
    }

    /**
     * @throws JsonException
     * @throws FormattersException
     */
    public function testJsonFormatterThrowsOnEncodeFailure(): void
    {
        $a = [];
        $a['self'] = &$a;

        $this->expectException(\JsonException::class);
        $this->expectExceptionMessage('Recursion detected');

        json([$a]);
    }
}
