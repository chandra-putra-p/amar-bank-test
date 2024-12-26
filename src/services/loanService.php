<?php

namespace Services;

use Models\Loan;
use Utils\LoggerUtil;

class LoanService
{
    private $logger;

    public function __construct()
    {
        $this->logger = new LoggerUtil('loanService');
    }

    /**
     * NOTE: below block, can improved using `LoanSaver` interface.
     *  Create class let's say `LoanJsonSaver` implements `LoanSaver`
     *  and then inject via file /config/dependencies.php using `LoanJsonSaver` instance.
     *
     * the LoanService constructor become:
     * ```
     *  public function __construct(LoanSaver $loanSaver)
     *  {
     *      $this->loanSaver = $loanSaver;
     *  }
     *  ...
     *
     *  public function create(Loan $loan)
     *  {
     *      ...
     *      $this->loanSaver->save($loan);
     *      ...
     *  }
     * ```
     */
    public function create(Loan $loan)
    {
        $this->logger->info('Data want to save ', ["data" => $loan]);

        // Read existing loan data
        $jsonFile = __DIR__ . '/../../_database/loans.json';
        $existingData = [];
        $this->logger->info('Reading existing data from ' . $jsonFile);
        $this->logger->info('Is file exists? ', ['exists' => file_exists($jsonFile)]);
        if (file_exists($jsonFile)) {
            $jsonContent = file_get_contents($jsonFile);
            $existingData = json_decode($jsonContent, true) ?? [];
        }

        array_push($existingData, $loan);

        // Write to loan JSON file
        $this->logger->info("Writing data to $jsonFile", ["data" => $existingData]);
        file_put_contents($jsonFile, json_encode($existingData, JSON_PRETTY_PRINT));

        return $loan;
    }
}
