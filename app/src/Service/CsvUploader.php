<?php

namespace App\Service;

use App\Interfaces\UploadInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Interfaces\FileInterface;

class CsvUploader implements UploadInterface
{
    private $targetDir;
    private $slugger;

    public function __construct(ParameterBagInterface $params, SluggerInterface $slugger)
    {
        $this->targetDir = $params->get('csv-files');
        $this->slugger = $slugger;
    }

    public function upload(FileInterface $csv): void
    {
        try {
            $originalFilename = pathinfo($csv->file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename . '-' . uniqid() . '.csv';
            $csv->file->move($this->targetDir, $fileName);
            $csv->setDir($this->targetDir);
            $csv->setName($fileName);
        } catch (FileException $e) {
            // logs
            throw new FileException('Failed to upload file: ' . $e->getMessage());
        }
    }
}
