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
        'doj',
        'payment_terms',
        'support_staff',
        'safety',
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
