<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'project_type'
    ];

    protected $casts = [
        'trade_category' => 'array',
        'project_type' => 'array',
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

    public function getProjectTypeModelsAttribute()
    {
        if (is_array($this->project_type)) {
            return ProjectType::whereIn('id', $this->project_type)->get();
        }
        return collect();
    }


    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'project_id');
    }

    public function getIsBookmarkedAttribute()
    {
        if (Auth::guard('contractor')->check()) {
            $userId = Auth::guard('contractor')->id();
            $userType = 'contractor';
        } elseif (Auth::guard('subcontractor')->check()) {
            $userId = Auth::guard('subcontractor')->id();
            $userType = 'subcontractor';
        } else {
            return 0;
        }
        return $this->bookmarks()->where(['user_id' => $userId, 'type' => $userType])->exists();
    }

    public function reviews()
    {
        return $this->morphMany(ReviewSubContractor::class, 'project');
    }

    public function contractorReviews()
    {
        return $this->morphMany(ReviewContractor::class, 'project');
    }

    public function unlockedProjects()
    {
        return $this->morphMany(UnlockedProject::class, 'user');
    }
}
