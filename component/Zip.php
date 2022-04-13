<?php
declare(strict_types=1);

namespace Phant\File;
use Phant\File\File;
use \ZipArchive;

class Zip extends File
{
	public function unarchive(?string $unarchiveDirectory = null): array
	{
		if ($unarchiveDirectory) {
			$unarchiveDirectory = self::getTemoraryDirectory() . pathinfo($this->path, PATHINFO_FILENAME) . '/';
		}
		
		$files = [];
		
		$zip = new ZipArchive;
		$zip->open($this->path);
		if ($zip->extractTo($unarchiveDirectory) == true) {
			for ($i = 0; $i < $zip->numFiles; $i++) {
				$files[ $zip->getNameIndex($i) ] = new File($unarchiveDirectory . $zip->getNameIndex($i));
			}
		}
		$zip->close();
		
		return $files;
	}
}
