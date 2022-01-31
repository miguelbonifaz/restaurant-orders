<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuOrder extends Model
{
    protected $table = 'menu_order';

    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity'
    ];
}