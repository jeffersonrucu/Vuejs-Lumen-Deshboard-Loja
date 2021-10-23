<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class freddom_fashion_users extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'token',
        'name',
        'email',
        'password'
    ];
}
