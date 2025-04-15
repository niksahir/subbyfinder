<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'plan_key',
        'description',
        'billing_type',
        'price',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];

}
