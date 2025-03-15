<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'sub_contractor_id',
        // 'certificate_name',
        'file_path'
    ];

    public function subContractor()
    {
        return $this->belongsTo(SubContractor::class);
    }
}
