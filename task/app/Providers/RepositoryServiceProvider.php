<?php

namespace App\Providers;

use App\Repository\Interfaces\TransactionRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }
}
