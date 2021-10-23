<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class freddom_fashion_product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'barcode',
        'name',
        'value',
        'amount',
        'image'
    ];
}
