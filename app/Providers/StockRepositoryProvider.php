<?php

namespace App\Providers;

use App\Repository\Implements\Stock\StockCategory;
use App\Repository\StockRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class StockRepositoryProvider extends ServiceProvider
{

    public function register():void
    {
        $this->app->bind(StockRepositoryInterface::class, StockCategory::class);
    }

    public function boot():void
    {
        //
    }
}
