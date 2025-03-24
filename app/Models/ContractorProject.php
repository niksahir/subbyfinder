<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorProject extends Model
{
    use HasFactory;

    protected $table = 'contractor_projects';

    protected $fillable = [
        'contractor_id',
        'project_logo',
        'project_name',
        'location',
        'description',
        'abn',
        'license',
        'trade_category',
        'budget',
    ];

    protected $casts = [
        'trade_category' => 'array',
    ];

    // Relationship with Contractor
    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function getExpertiseNamesAttribute()
    {
        if (is_array($this->trade_category)) {
            return Expertise::whereIn('id', $this->trade_category)->pluck('name')->toArray();
        }
        return [];
    }
}
