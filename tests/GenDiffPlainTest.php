<?php

declare(strict_types=1);

namespace Differ\Tests;

use Differ\Formatters\FormattersException;
use Differ\Parsing\ParseException;
use JsonException;
use PHPUnit\Framework\TestCase;

use function Differ\Formatters\plain;
use function Differ\Differ\genDiff;

final class GenDiffPlainTest extends TestCase
{
    /**
     * @throws ParseException
     * @throws JsonException
     * @throws FormattersException
     */
    public function testPlainJsonDiff(): void
    {
        $file1 = __DIR__ . '/Fixtures/nested_file1.json';
        $file2 = __DIR__ . '/Fixtures/nested_file2.json';
        $expected = file_get_contents(__DIR__ . '/Fixtures/expected_plain.txt');

        $this->assertSame($expected, genDiff($file1, $file2, 'plain'));
    }

    public function testPlainFormatterThrowsOnUnknownNodeType(): void
    {
        $diff = [
            [
                'type' => 'invalid',
                'key' => 'testKey',
                'value' => 'oops',
            ],
        ];

        $this->expectException(FormattersException::class);
        $this->expectExceptionMessage('Unknown node type: invalid');

        plain($diff);
    }
}
