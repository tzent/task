<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\Interfaces\DataHandlerInterface;
use App\Repository\Interfaces\TransactionRepositoryInterface;
use Illuminate\Support\Collection;

class DbDataHandler extends AbstractHandler implements DataHandlerInterface
{
    /**
     * @var TransactionRepositoryInterface
     */
    private TransactionRepositoryInterface $transactionRepository;

    /**
     * @param TransactionRepositoryInterface $transactionRepository
     */
    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        parent::__construct();

        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        return $this->transactionRepository->all();
    }
}
