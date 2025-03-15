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
        'values'
    ];

    protected $casts = [
        'expertise_in' => 'array',
        'project_types' => 'array',
        'availability' => 'array'
    ];

    public function expertises()
    {
        return $this->belongsToMany(Expertise::class);
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
