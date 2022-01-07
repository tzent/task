<?php

namespace App\Repository;

use App\Models\Transaction;
use App\Repository\Interfaces\TransactionRepositoryInterface;
use Illuminate\Support\Collection;

class TransactionRepository extends AbstractRepository implements TransactionRepositoryInterface
{
    /**
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }
}
