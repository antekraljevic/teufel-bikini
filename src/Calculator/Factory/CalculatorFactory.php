<?php

namespace App\Calculator\Factory;

use App\Calculator\Business\CsvWriter;
use App\Calculator\Business\DatesCalculator;
use Psr\Log\LoggerInterface;

class CalculatorFactory
{
    public function createDatesCalculator(): DatesCalculator
    {
        return new DatesCalculator();
    }

    public function createCsvWriter(LoggerInterface $logger): CsvWriter
    {
        return new CsvWriter($logger);
    }
}