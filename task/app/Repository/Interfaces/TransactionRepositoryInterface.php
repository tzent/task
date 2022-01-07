<?php

namespace App\Repository\Interfaces;

use Illuminate\Support\Collection;

interface TransactionRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;
}
