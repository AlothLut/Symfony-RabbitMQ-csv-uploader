<?php

namespace App\Service;

use App\Interfaces\FileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CsvFile implements FileInterface
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @var string
     */
    public $reportCopy;

    /**
     * @var string
     */
    public $fileName;

    /**
     * @var string
     */
    public $dir;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function setName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function getName(): string
    {
        return $this->fileName;
    }

    public function setDir(string $dir): void
    {
        $this->dir = $dir;
    }

    public function getDir(): string
    {
        return $this->dir;
    }

    public function setReportCopy(string $reportCopy): void
    {
        $this->reportCopy = $reportCopy;
    }

    public function getReportCopy(): string
    {
        return $this->reportCopy;
    }
}
