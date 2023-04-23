<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\AcessUserRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Services\Stock\StockServices;
use Illuminate\Http\Request;

class UserConroler extends Controller
{
    private AcessUserRepositoryInterface $acessRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(AcessUserRepositoryInterface $acessRepository, UserRepositoryInterface $userRepository)
    {
        $this->acessRepository = $acessRepository;
        $this->userRepository = $userRepository;
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function register(Request $request)
    {
        return (new StockServices())->createProduct($request->all());
    }

    public function login(Request $request)
    {
        return $this->acessRepository->login($request);
    }

    public function logout(Request $request)
    {
        $this->acessRepository->logout();
    }
    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
