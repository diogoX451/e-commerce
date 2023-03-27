<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function user()
    {
        return $this->morphByMany(User::class, 'users_permissions');
    }
    public function roles()
    {
        return $this->morphByMany(Role::class, 'roles_permissions');
    }
}
