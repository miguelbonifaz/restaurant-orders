<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $fillable = [
        'table_number',
        'client_name',
    ];

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class);
    }
}