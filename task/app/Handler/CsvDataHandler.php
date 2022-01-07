<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\Interfaces\DataHandlerInterface;
use Illuminate\Support\Collection;

class CsvDataHandler extends AbstractHandler implements DataHandlerInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        $csv = array_map('str_getcsv', file(storage_path() . '/csv_data/transactions.csv'));
        array_walk($csv, function(&$row) use ($csv) {
            $row = array_combine($csv[0], $row);
        });
        array_shift($csv);

        return new Collection($csv);
    }
}
