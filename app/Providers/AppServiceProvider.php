<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(EnderecoServiceProvider::class);
        $this->app->register(StockRepositoryProvider::class);

    }

    public function boot(): void
    {
        //
    }
}
