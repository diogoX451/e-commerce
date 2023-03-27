<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fields = [
        'name',
        'description'
    ];

    public function user()
    {
        return $this->morphByMany(User::class, 'role_user');
    }
    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'roles_permissions');
    }
}
