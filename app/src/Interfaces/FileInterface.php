<?php

namespace App\Interfaces;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileInterface
{
    public function __construct(UploadedFile $file);
    public function setName(string $filename): void;
    public function getName(): string;
    public function removeFile(): void;
    public function setReportCopy(string $reportCopy): void;
    public function getReportCopy(): string;
    public function removeReportCopy(): void;
    public function setDir(string $dir): void;
    public function getDir(): string;
}
