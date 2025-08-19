<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'phone',
        'opening_hours',
        'image',
        'is_active',
    ];

    protected $casts = [
        'opening_hours' => 'array',
    ];
}
