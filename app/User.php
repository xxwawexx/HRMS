<?php

namespace App;

use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Task
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name', 'email', 'password', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function personal_details()
    {
        return $this->hasMany('App\PersonalDetails');
    }

    public function employees()
    {
        return $this->hasMany('App\Employee');
    }

    public function employment_management()
    {
        return $this->hasMany('App\EmploymentManagement');
    }

    public function employee_working_hours()
    {
        return $this->hasMany('App\EmployeeWorkingHours');
    }

    public function employee_socials()
    {
        return $this->hasMany('App\EmployeeSocial');
    }

    public function government_i_d_s()
    {
        return $this->hasMany('App\GovernmentID');
    }

    public function emergency_contact()
    {
        return $this->hasMany('App\EmergencyContact');
    }

    public function employee_documents()
    {
        return $this->hasMany('App\EmployeeDocuments');
    }
}
