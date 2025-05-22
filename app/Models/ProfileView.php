<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileView extends Model
{
    protected $fillable = [
        'user_id',
        'user_type',
        'profile_type',
        'profile_id',
    ];
}
