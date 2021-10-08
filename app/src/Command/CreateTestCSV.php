<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * class creates a large mock-csv-file for tests
 */
class CreateTestCSV extends Command
{
    /**
     * @var ParameterBagInterface
     */
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        parent::__construct();
    }
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-testcsv';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fp = fopen($this->params->get('csv-files') . "mock.csv", "w");

        for ($i = 1; $i <= 100000; ++$i) {
            if ($i == 1) {
                $field = ["code" . $i, 'StaticValue1'];
            } elseif ($i == 2) {
                $field = ["code" . $i, 'StaticValue2'];
            } elseif ($i == 3) {
                $field = ["code" . $i, 'Static#Value>Error'];
            } else {
                $field = ["code" . $i, bin2hex(random_bytes(3))];
            }
            fputcsv($fp, $field);
        }
        fclose($fp);
        return Command::SUCCESS;
    }
}
