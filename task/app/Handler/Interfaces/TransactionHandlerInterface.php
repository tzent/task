<?php

declare(strict_types=1);

namespace App\Handler\Interfaces;

use Illuminate\Support\Collection;

interface TransactionHandlerInterface
{
    /**
     * @param string|null $source
     * @return Collection|null
     */
    public function getTransactionsList(?string $source): ?Collection;
}
