<?php

declare(strict_types=1);

namespace Test\Service;

use PHPUnit\Framework\TestCase;

use Phant\File\Csv;

final class CsvTest extends TestCase
{
    protected string $filePath;
    protected Csv $fixture;

    public function setUp(): void
    {
        $this->fixture = new Csv(__DIR__ . '/../fixture/data.csv');
    }

    public function testVerifyColumns(): void
    {
        $result = $this->fixture->verifyColumns([
            'id',
            'firstname',
            'lastname',
        ]);

        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixture->verifyColumns([
            'foo',
            'bar',
        ]);

        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixture->verifyColumns([
            'ID',
            'firstname',
            'lastname',
        ]);

        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    public function testGetNbLines(): void
    {
        $result = $this->fixture->getNbLines();

        $this->assertIsInt($result);
        $this->assertEquals(1001, $result);
    }

    public function testReadFileByLine(): void
    {
        $lines = $this->fixture->readFileByLine();

        $this->assertInstanceOf(\Generator::class, $lines);

        foreach ($lines as $line) {
            $this->assertIsArray($line);
            $this->assertCount(3, $line);
        }
    }
}
