<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubcontractorProtfolio extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'project_name',
        'location',
        'place_id',
        'lat',
        'lng',
        'images',
        'description',
        'price',
    ];

    public function SubContractor()
    {
        return $this->belongsTo(Subcontractor::class, 'user_id');
    }
}
