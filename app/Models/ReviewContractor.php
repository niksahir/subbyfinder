<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewContractor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_type',
        'project_id',
        'project_type',
        'contacted',
        'reason_no_contact',
        'agreed',
        'dealings_review',
        'completed',
        'final_review',
        'completion_estimate',
        'workmanship',
        'integrity',
        'presentation',
        'communication',
        'completion_estimate_checked_at',
        'created_at',
        'updated_at',
    ];


    public function user()
    {
        return $this->morphTo();
    }

    public function project()
    {
        return $this->morphTo();
    }
}
