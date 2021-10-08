<?php

namespace App\Service;

use App\Interfaces\ReportFileInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use App\Interfaces\FileInterface;
use App\Traits\BannedChar;

/**
 * Сlass for generating a report based on the uploaded file
 */
class CsvReport implements ReportFileInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $targetDir;

    /**
     * @var string
     */
    private $reportFile;

    /**
     * @var string
     */
    private $sourceFile;

    use BannedChar;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function init(FileInterface $csv): void
    {
        $this->sourceFile = $csv->getDir() . $csv->getName();
        if (!$this->filesystem->exists($this->sourceFile)) {
            throw new \Exception('Source file does not exist');
        }
        $this->reportFile = $csv->getDir() . "report-" . $csv->getName();
        $this->handle();
        $csv->setReportCopy("report-" . $csv->getName());
    }

    private function handle(): void
    {
        $this->filesystem->touch($this->reportFile);
        $handle = fopen($this->sourceFile, "r");
        $report = fopen($this->reportFile, "w");
        while (($raw_string = fgets($handle)) !== false) {
            $raw = str_getcsv($raw_string);
            $code = $raw[0];
            $name = $raw[1];
            $error = "Error=''";
            $bannedChar = BannedChar::find($name);
            if (!empty($bannedChar)) {
                $error = "Error=Недопустимый символ(ы): " . implode(",", $bannedChar) . " в поле Название";
            }
            fputcsv($report, [$code, $name, $error]);
        }
        fclose($handle);
        fclose($report);
    }

    public function getFileResponse()
    {
        $response = new BinaryFileResponse($this->reportFile);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            basename($this->reportFile)
        );

        return $response;
    }
}
