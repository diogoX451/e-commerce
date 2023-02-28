<?php

namespace App\Repository\Implements\User;

use App\Models\User;
use App\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }
    public function create($request)
    {
        $req = validator($request, [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);
        if ($req->fails()) {
            return response()->json($req->errors(), 400);
        }
        $user = User::create([
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'phone' => $request['phone'],
        ]);
        return $user;
    }
    public function delete($id)
    {
        return User::destroy($id);
    }
    public function find($id)
    {
        return User::find($id);
    }
    public function update($request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }
}
