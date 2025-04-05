<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'facebook_id',
        'avatar',
        'position_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function employeeDetails()
    {
        return $this->hasOne(EmployeeDetails::class);
    }

    public function shiftRegistrations()
    {
        return $this->hasMany(ShiftRegistration::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function evaluations()
    {
        return $this->hasMany(EmployeeEvaluation::class);
    }

    public function evaluatedEvaluations()
    {
        return $this->hasMany(EmployeeEvaluation::class, 'evaluated_by');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
