<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SubContractor extends Authenticatable
{
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
        'email_alerts'
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
}
