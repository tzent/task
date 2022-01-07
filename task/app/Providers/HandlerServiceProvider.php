<?php

namespace App\Providers;

use App\Handler\Interfaces\TransactionHandlerInterface;
use App\Handler\TransactionHandler;
use Illuminate\Support\ServiceProvider;

class HandlerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TransactionHandlerInterface::class, TransactionHandler::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
