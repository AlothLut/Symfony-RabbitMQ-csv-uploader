<?php

namespace App\Interfaces;

use App\Interfaces\FileInterface;

interface ReportFileInterface
{
    public function init(FileInterface $file): void;
    public function getFileResponse();
}
