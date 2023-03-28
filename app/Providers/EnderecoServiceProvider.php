<?php

namespace App\Providers;

use App\Repository\EnderecoRepositoryInterface;
use App\Repository\Implements\Endereco\EnderecoRepository;
use Illuminate\Support\ServiceProvider;

class EnderecoServiceProvider extends ServiceProvider
{

    public function register():void
    {
        $this->app->bind(EnderecoRepositoryInterface::class, EnderecoRepository::class);
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
