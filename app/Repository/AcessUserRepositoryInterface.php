<?php

namespace App\Repository;

interface AcessUserRepositoryInterface
{
    public function login($request);
    public function logout();
}
