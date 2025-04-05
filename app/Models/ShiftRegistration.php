<?php
// app/Models/ShiftRegistration.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftRegistration extends Model
{
    protected $fillable = [
        'shift_id',
        'user_id',
        'position_id',
        'status',
        'check_in_time',
        'check_out_time',
        'performance_rating',
        'manager_comments',
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function tasks()
    {
        return $this->hasMany(ShiftRegistrationTask::class);
    }
}
