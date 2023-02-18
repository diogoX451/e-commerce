<?php

namespace App\Providers;

use App\Repository\AcessUserRepositoryInterface;
use App\Repository\Eloquent\AcessRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(AcessUserRepositoryInterface::class, AcessRepository::class);
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
