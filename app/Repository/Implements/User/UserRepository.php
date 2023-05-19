<?php

namespace App\Repository\Implements\User;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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
            'password' => $request['password'],
            'phone' => $request['phone'],
        ]);

        $role = Role::findByName('user');

        $user->assignRole($role);

        return $user;
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }
    public function getUser($id)
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
