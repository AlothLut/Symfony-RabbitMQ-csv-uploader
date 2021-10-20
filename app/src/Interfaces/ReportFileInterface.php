<?php

namespace App\Interfaces;

use App\Interfaces\FileInterface;

interface ReportFileInterface
{
    public function create(FileInterface $file): void;
    public function getFileResponse();
}
