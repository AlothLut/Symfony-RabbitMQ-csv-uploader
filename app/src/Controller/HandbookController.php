<?php
namespace App\Controller;

use App\Message\CsvFilesMessage;
use App\Service\CsvFile;
use App\Service\CsvReport;
use App\Service\CsvUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class HandbookController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('upload/index.html.twig');
    }

    public function new (Request $request, CsvUploader $uploader, CsvReport $report, MessageBusInterface $bus)
    {
        $token = $request->get("token");

        if (!$this->isCsrfTokenValid('upload', $token)) {
            return new Response("Operation not allowed", Response::HTTP_BAD_REQUEST,
                ['content-type' => 'text/plain']);
        }

        $file = $request->files->get('csv-file');

        if (empty($file)) {
            return new Response("No file specified",
                Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }

        $csv = new CsvFile($file);
        $uploader->upload($csv);
        $report->create($csv);
        $bus->dispatch(new CsvFilesMessage($csv->getName(), $csv->getReportCopy(), $csv->getDir()));

        return $report->getFileResponse();
    }
}
