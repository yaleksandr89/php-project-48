<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenDiffYamlTest extends TestCase
{
    public function testFlatYamlDiff(): void
    {
        $file1 = __DIR__ . '/Fixtures/file1.yml';
        $file2 = __DIR__ . '/Fixtures/file2.yml';

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
}
