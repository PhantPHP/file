<?php

declare(strict_types=1);

namespace Phant\File;

class File
{
    public function __construct(
        protected readonly string $path
    ) {
    }

    public function exist(): bool
    {
        return file_exists($this->path);
    }

    public function delete()
    {
        unlink($this->path);
    }

    public static function getTemoraryDirectory(): string
    {
        return realpath(sys_get_temp_dir()) . '/';
    }

    public static function cleanFilename(string $fileName): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileName = pathinfo($fileName, PATHINFO_FILENAME);

        // Clean local filename
        $fileName = pathinfo($fileName, PATHINFO_FILENAME);

        $fileName = strtr(
            $fileName,
            ['Š' => 'S','Ž' => 'Z','š' => 's','ž' => 'z','Ÿ' => 'Y','À' => 'A','Á' => 'A','Â' => 'A','Ã' => 'A','Ä' => 'A','Å' => 'A','Ç' => 'C','È' => 'E','É' => 'E','Ê' => 'E','Ë' => 'E','Ì' => 'I','Í' => 'I','Î' => 'I','Ï' => 'I','Ñ' => 'N','Ò' => 'O','Ó' => 'O','Ô' => 'O','Õ' => 'O','Ö' => 'O','Ø' => 'O','Ù' => 'U','Ú' => 'U','Û' => 'U','Ü' => 'U','Ý' => 'Y','à' => 'a','á' => 'a','â' => 'a','ã' => 'a','ä' => 'a','å' => 'a','ç' => 'c','è' => 'e','é' => 'e','ê' => 'e','ë' => 'e','ì' => 'i','í' => 'i','î' => 'i','ï' => 'i','ñ' => 'n','ò' => 'o','ó' => 'o','ô' => 'o','õ' => 'o','ö' => 'o','ø' => 'o','ù' => 'u','ú' => 'u','û' => 'u','ü' => 'u','ý' => 'y','ÿ' => 'y']
        );

        $fileName = strtr(
            $fileName,
            ['Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss', 'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u']
        );

        $fileName = str_replace('\'', ' ', $fileName);
        $fileName = preg_replace('/\s+/', ' ', $fileName);
        $fileName = trim($fileName);
        $fileName = preg_replace(['/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'], ['_', '.', ''], $fileName);

        $extension = strtolower($extension);
        $extension = trim($extension);

        return $fileName . ($extension ? '.' . $extension : '');
    }

    public static function download(string $distantPath, ?string $localPath = null): self
    {
        if (!$localPath) {
            $localPath = self::getTemoraryDirectory() . date('Y-m-d_H-i-s') . '-' . self::cleanFilename($distantPath);
        }

        file_put_contents($localPath, fopen($distantPath, 'r'));

        return new self($localPath);
    }
}
