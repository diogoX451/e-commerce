<?php

namespace App\Providers;

use App\Repository\UserRepositoryInterface;
use App\Repository\Implements\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }


    public function boot(): void
    {
        //
    }
}
