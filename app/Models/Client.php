<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
  use HasApiTokens, HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'password',
    ];
    protected $casts = [
        'password' => 'hashed',
    ];
}
