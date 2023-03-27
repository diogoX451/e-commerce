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
