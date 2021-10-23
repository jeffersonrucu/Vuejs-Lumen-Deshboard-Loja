<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class freddom_fashion_clients extends Model
{
    protected $table = 'clients';
    protected $fillable = [
        'name',
        'email',
        'cell_phone'
    ];
}
