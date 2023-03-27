<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EnderecoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            App\Repository\EnderecoRepositoryInterface::class,
            App\Repository\Implements\Endereco\EnderecoRepository::class
        );
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
