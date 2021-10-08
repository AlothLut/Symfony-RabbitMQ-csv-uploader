<?php

namespace App\Message;

use App\Entity\Handbook;
use Symfony\Component\Filesystem\Filesystem;
use App\Traits\BannedChar;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Message\CsvFilesMessage;

class CsvDataHandler implements MessageHandlerInterface
{
    const BATCH_SIZE = 20;

    /**
     * @var ManagerRegistry
     */
    private $manager;

    use BannedChar;

    public function __invoke(CsvFilesMessage $message)
    {
        $this->saveToDB($message->getDir() . $message->getFileName());
        $this->removeFiles($message);
    }

    public function __construct(ManagerRegistry $manager)
    {
        $this->manager = $manager;
    }

    private function saveToDB($csv)
    {
        $handle = fopen($csv, "r");

        $lineNumber = 1;
        $em = $this->manager->getManager();

        while (($raw_string = fgets($handle)) !== false) {
            $lineNumber++;
            $raw = str_getcsv($raw_string);
            $code = $raw[0];
            $name = $raw[1];

            $bannedChar = BannedChar::find($name);

            if (!empty($bannedChar)) {
                continue;
            }

            $entity = $em->getRepository(Handbook::class)->findOneBy(["code" => $code]);
            if ($entity === null) {
                $entity = new Handbook();
                $entity->setCode($code);
                $entity->setName($name);
            } else {
                $entity->setName($name);
            }
            $em->persist($entity);

            if (($lineNumber % self::BATCH_SIZE) === 0) {
                $em->flush();
                $em->clear();
            }
        }

        $em->flush();
        $em->clear();

        fclose($handle);
    }

    private function removeFiles($message): void
    {
        $filesystem = new Filesystem;
        $filesystem->remove($message->getDir() . $message->getFileName());
        $filesystem->remove($message->getDir() . $message->getCopyName());
    }
}
