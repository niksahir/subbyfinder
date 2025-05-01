<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalPay extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'user_type',
        'payable_type',
        'price',
        'is_over',
        'stripe_session_id',
    ];
    protected $casts = [
        'is_over' => 'boolean',
    ];

    public function user()
    {
        return $this->morphTo();
    }

}
