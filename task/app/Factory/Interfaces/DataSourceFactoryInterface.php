<?php

declare(strict_types=1);

namespace App\Factory\Interfaces;

use App\Handler\Interfaces\DataHandlerInterface;

interface DataSourceFactoryInterface
{
    /**
     * @param string $source
     * @return DataHandlerInterface
     */
    public static function create(string $source): DataHandlerInterface;
}
