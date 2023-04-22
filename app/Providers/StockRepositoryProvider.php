<?php

namespace App\Providers;

use App\Repository\Implements\Stock\StockRepository;
use App\Repository\StockRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class StockRepositoryProvider extends ServiceProvider
{

    public function register():void
    {
        $this->app->bind(StockRepositoryInterface::class, StockRepository::class);
    }

    public function boot():void
    {
        //
    }
}
