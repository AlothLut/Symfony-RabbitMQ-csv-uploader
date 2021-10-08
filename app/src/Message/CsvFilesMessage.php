<?php

namespace App\Message;

/**
 * Class adding a queue for asynchronous file processing
 */
class CsvFilesMessage
{
    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $copyFileName;

    /**
     * @var string
     */
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
