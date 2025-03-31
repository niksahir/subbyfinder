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
        'subcontractor_email_alerts'
    ];

    protected $casts = [
        'trade_category' => 'array',
        'project_types' => 'array',
        'availability' => 'array'
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
}
