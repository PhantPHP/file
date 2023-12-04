<?php

declare(strict_types=1);

namespace Phant\File;

use Phant\File\File;
use ZipArchive;

class Zip extends File
{
    public function unarchive(?string $unarchiveDirectory = null): ?array
    {
        if (!$this->exist()) {
            return null;
        }

        if (is_null($unarchiveDirectory)) {
            $unarchiveDirectory = self::getTemoraryDirectory() . '/';
        }

        $files = [];

        $zip = new ZipArchive();
        $zip->open($this->path);
        if ($zip->extractTo($unarchiveDirectory) == true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filepath = realpath($unarchiveDirectory . $zip->getNameIndex($i));
                if (is_dir($filepath)) {
                    continue;
                }
                $files[ $zip->getNameIndex($i) ] = new File($filepath);
            }
        }
        $zip->close();

        return $files;
    }
}
