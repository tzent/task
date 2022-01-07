<?php

declare(strict_types=1);

namespace App\Factory;

use App\Factory\Interfaces\DataSourceFactoryInterface;
use App\Handler\CsvDataHandler;
use App\Handler\DbDataHandler;
use App\Handler\Interfaces\DataHandlerInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;

class DataSourceFactory implements DataSourceFactoryInterface
{
    /**
     * @param string $source
     * @return DataHandlerInterface
     * @throws BindingResolutionException
     */
    public static function create(string $source): DataHandlerInterface
    {
        return match ($source) {
            'db' => app()->make(DbDataHandler::class),
            'csv' => app()->make(CsvDataHandler::class),
            default => throw new InvalidArgumentException('Invalid source ' . $source),
        };
    }
}
