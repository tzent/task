<?php

declare(strict_types=1);

namespace App\Handler;

use App\Factory\DataSourceFactory;
use App\Handler\Interfaces\TransactionHandlerInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;

class TransactionHandler extends AbstractHandler implements TransactionHandlerInterface
{
    /**
     * @param string|null $source
     * @return Collection|null
     * @throws BindingResolutionException
     */
    public function getTransactionsList(?string $source): ?Collection
    {
        try {
            return DataSourceFactory::create($source)->getData();
        } catch (\InvalidArgumentException $e) {
            $this->addError('source', $e->getMessage());

            return null;
        }
    }
}
