<?php

namespace App\Calculator\Business;

use Exception;
use Psr\Log\LoggerInterface;

class CsvWriter
{
    private const CSV_EXTENSION = '.csv';
    private const WRITE_MODE = 'w';
    
    /**
     * @var Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function writeToCSV(array $data, string $fileName): int
    {
        $fileName = $fileName . self::CSV_EXTENSION;
        try {
            $file = fopen($fileName, self::WRITE_MODE);
    
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
    
            fclose($file);
            return 1;
        } catch (Exception $e) {
            $this->logger->error('Error occured: ' . $e->getMessage());
            return -1;
        }
    }
}