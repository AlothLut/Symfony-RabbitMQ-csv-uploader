<?php

namespace App\Message;

class CsvFilesMessage
{
    private $fileName;

    private $copyFileName;

    private $dir;

    public function __construct(string $fileName, string $copyFileName, string $dir)
    {
        $this->fileName = $fileName;

        $this->copyFileName = $copyFileName;

        $this->dir = $dir;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getCopyName(): string
    {
        return $this->copyFileName;
    }

    public function getDir(): string
    {
        return $this->dir;
    }
}
