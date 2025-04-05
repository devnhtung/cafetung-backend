<?php
// app/Models/Task.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description'];

    public function positionTasks()
    {
        return $this->hasMany(PositionTask::class);
    }

    public function shiftTypeTasks()
    {
        return $this->hasMany(ShiftTypeTask::class);
    }

    public function shiftRegistrationTasks()
    {
        return $this->hasMany(ShiftRegistrationTask::class);
    }
}
