<?php
// app/Models/ShiftRegistrationTask.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftRegistrationTask extends Model
{
    protected $fillable = ['shift_registration_id', 'task_id', 'is_custom', 'status', 'completed_at'];

    protected $casts = [
        'is_custom' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function shiftRegistration()
    {
        return $this->belongsTo(ShiftRegistration::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
