<?php

namespace App\Calculator\Command;

use App\Calculator\Factory\CalculatorFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

class CalculatePayrollDatesCommand extends Command
{
    private const COMMAND_NAME = 'calculate';
    private const COMMAND_DESCRIPTION = 'Calculates payroll dates';
    private const COMMAND_HELP = 'This command calculates payroll dates';
    private const ARGUMENT_FILE_NAME = 'file_name';
    private const ARGUMENT_FILE_NAME_DESCRIPTION = 'Name of CSV file';

    /**
     * @var App\Calculator\Factory\CalculatorFactory
     */
    private $calculatorFactory;
    private $logger;

    public function __construct(CalculatorFactory $calculatorFactory, LoggerInterface $logger)
    {
        parent::__construct();
        $this->calculatorFactory = $calculatorFactory;
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
        ->setDescription(self::COMMAND_DESCRIPTION)
        ->setHelp(self::COMMAND_HELP)
        ->addArgument(self::ARGUMENT_FILE_NAME, InputArgument::REQUIRED, self::ARGUMENT_FILE_NAME_DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dates = $this->calculatorFactory->createDatesCalculator()->calculatePayrollDates();
        $fileName = $input->getArgument(self::ARGUMENT_FILE_NAME);

        return $this->calculatorFactory->createCsvWriter($this->logger)->writeToCSV($dates, $fileName);
    }
}