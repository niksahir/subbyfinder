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

    public function Contractor()
    {
        return $this->belongsTo(Contractor::class, 'user_id');
    }

    public function SubContractor()
    {
        return $this->belongsTo(SubContractor::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(ContractorProject::class, 'project_id');
    }

   
}
