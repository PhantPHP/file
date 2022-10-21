<?php

declare(strict_types=1);

namespace Test\Service;

use PHPUnit\Framework\TestCase;

use Phant\File\Zip;

final class ZipTest extends TestCase
{
    protected string $filePath;
    protected Zip $fixture;

    public function setUp(): void
    {
        $this->fixture = new Zip(__DIR__ . '/../fixture/archive.zip');
    }

    public function testUnarchive(): void
    {
        $result = $this->fixture->unarchive();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        foreach ($result as $file) {
            $file->delete();
        }
    }

    public function testUnarchiveFail(): void
    {
        $result = (new Zip('foo-bar.zip'))->unarchive();

        $this->assertNull($result);
    }
}
