<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'from_user_id',
        'sender_type',
        'to_user_id',
        'receiver_type',
        'body',
        'image',
    ];


    public function sender()
    {
        return $this->morphTo(__FUNCTION__, 'sender_type', 'from_user_id');
    }

    public function receiver()
    {
        return $this->morphTo(__FUNCTION__, 'receiver_type', 'to_user_id');
    }
}
