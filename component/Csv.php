<?php

declare(strict_types=1);

namespace Phant\File;

use Phant\File\File;

class Csv extends File
{
    protected array $columns;

    public function __construct(
        protected readonly string $path,
        protected readonly bool $headerInFirstLine = true,
        protected readonly string $delimiter = ';',
        protected readonly string $textSeparator = '"'
    ) {
        $this->loadHeader();
    }

    public function verifyColumns(array $columns): bool
    {
        if (count($this->columns) != count($columns)) {
            return false;
        }

        foreach ($this->columns as $colonne) {
            if (!in_array($colonne, $columns)) {
                return false;
            }
        }

        return true;
    }

    public function getNbLines(): int
    {
        $nbLines = 0;

        $handle = fopen($this->path, 'r');

        while (!feof($handle)) {
            fgets($handle);
            $nbLines++;
        }

        fclose($handle);

        return $nbLines;
    }

    public function readFileByLine(): \Generator
    {
        $handle = fopen($this->path, 'r');

        $lineNumber = 0;
        while (($cells = fgetcsv($handle, 0, $this->delimiter, $this->textSeparator)) !== false) {
            if ($this->headerInFirstLine && $lineNumber === 0) {
                ++$lineNumber;
                continue;
            }

            $values = $this->headerInFirstLine ? array_combine($this->columns, $cells) : $cells;

            yield $values;

            ++$lineNumber;
        }

        fclose($handle);
    }

    private function loadHeader(): void
    {
        $handle = fopen($this->path, 'r');
        $this->columns = fgetcsv($handle, 0, $this->delimiter, $this->textSeparator);
        fclose($handle);
    }
}
