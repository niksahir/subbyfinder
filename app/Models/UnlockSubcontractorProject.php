<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnlockSubcontractorProject extends Model
{
    use SoftDeletes;
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
        return $this->belongsTo(SubContractor::class, 'project_id');
    }
}
