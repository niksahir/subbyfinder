<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnlockedProject extends Model
{
    protected $fillable = [
        'user_id',
        'user_type',
        'project_id',
    ];

    public function user()
    {
        return $this->morphTo();
    }

    public function project()
    {
        return $this->belongsTo(ContractorProject::class, 'project_id');
    }

}
