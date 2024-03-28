<?php

declare(strict_types=1);

namespace Test\Service;

use PHPUnit\Framework\TestCase;

use Phant\File\File;

final class FileTest extends TestCase
{
    protected string $filePath;
    protected File $fixture;

    public function setUp(): void
    {
        $this->filePath = sys_get_temp_dir() . '/file.' . uniqid() . '.txt';

        file_put_contents($this->filePath, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $this->filePath = realpath($this->filePath);

        $this->fixture = new File($this->filePath);
    }

    public function tearDown(): void
    {
        if (!file_exists($this->filePath)) {
            return;
        }

        unlink($this->filePath);
    }

    public function testGetPath(): void
    {
        $result = $this->fixture->getPath();

        $this->assertIsString($result);
    }

    public function testGet(): void
    {
        $result = $this->fixture->exist();

        $this->assertEquals(true, $result);
    }

    public function testDelete(): void
    {
        $this->fixture->delete();

        $result = file_exists($this->filePath);

        $this->assertEquals(false, $result);
    }

    public function testGetTemoraryDirectory(): void
    {
        $result = File::getTemoraryDirectory();

        $this->assertIsString($result);
    }

    public function testCleanFilename(): void
    {
        $result = File::cleanFilename(' µ \' û ');

        $this->assertIsString($result);
        $this->assertEquals('u_u', $result);

        $result = File::cleanFilename(' µ û . Jpg');

        $this->assertIsString($result);
        $this->assertEquals('u_u.jpg', $result);
    }

    public function testDownload(): void
    {
        $result = File::download(__DIR__ . '/../README.md');

        $this->assertInstanceOf(File::class, $result);

        $result->delete();
    }
}
