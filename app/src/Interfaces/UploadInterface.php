<?php

namespace App\Interfaces;

use App\Interfaces\FileInterface;

interface UploadInterface
{
    public function upload(FileInterface $file): void;
}
