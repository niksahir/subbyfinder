<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;


class SubContractor extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guard = 'subcontractor';
    protected $fillable = [
        'profile_photo',
        'business_name',
        'contact_name',
        'phone',
        'email',
        'password',
        'address',
        'support_staff_size',
        'years_in_business',
        'insurances',
        'abn',
        'licenses',
        'expertise_in',
        'project_types',
        'availability',
        'description',
        'values',
        'trade_category',
        'email_alerts',
        'subcontractor_email_alerts',
        'location',
        'place_id',
        'lat',
        'lng',
    ];

    protected $casts = [
        'trade_category' => 'array',
        'project_types' => 'array',
    ];

    // $expertiseList = $subContractor->expertise_list; // Returns collection of names
    public function getExpertiseListAttribute()
    {
        return collect($this->trade_category)->pluck('name');
    }

    public function projectTypes()
    {
        return $this->belongsToMany(ProjectType::class);
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    public function getExpertiseNamesAttribute()
    {
        if (is_array($this->trade_category)) {
            return Expertise::whereIn('id', $this->trade_category)->pluck('name')->toArray();
        }
        return [];
    }

    public function bookmarks()
    {
        return $this->hasMany(SubContractorsBookmark::class, 'subcontractor_id');
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

    public function unlockedProjects()
    {
        return $this->hasMany(UnlockSubcontractorProject::class, 'user_id');
    }

    public function subContractorProtfolio()
    {
        return $this->hasMany(SubcontractorProtfolio::class, 'user_id');
    }

    public function reviews()
    {
        return $this->morphMany(ReviewSubContractor::class, 'project');
    }

    public function subbyReviews()
    {
        return $this->morphMany(ReviewSubContractor::class, 'user');
    }
    public function scopeWithinRadius($query, float $lat, float $lng, float $radiusMetres = 50)
    {
        return $query->selectRaw(
            '*, (6371000 * acos(
            cos(radians(?)) *
            cos(radians(lat)) *
            cos(radians(lng) - radians(?)) +
            sin(radians(?)) *
            sin(radians(lat))
        )) AS distance_m',
            [$lat, $lng, $lat]
        )
            ->having('distance_m', '<=', $radiusMetres)
            ->orderBy('distance_m');
    }
}
