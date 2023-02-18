<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\AcessUserRepositoryInterface;
use Illuminate\Http\Request;

class UserConroler extends Controller
{
    private  AcessUserRepositoryInterface $acessRepository;

    public function __construct(AcessUserRepositoryInterface $acessRepository)
    {
        $this->acessRepository = $acessRepository;
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

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->token = $request->token;
        $user->save();
        return response()->json($user);
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
