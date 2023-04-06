<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory  ;
    
    protected $fillable = [
        'street',
        'number',
        'city',
        'country',
        'state',
        'zip_code',
        'complement',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class,'address_user','address_id');
    }
}