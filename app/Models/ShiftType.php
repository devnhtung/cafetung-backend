<?php

// app/Models/ShiftType.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftType extends Model
{
    protected $fillable = ['name', 'start_time', 'end_time'];

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function shiftTypeTasks()
    {
        return $this->hasMany(ShiftTypeTask::class);
    }
    public function tasks()
    {
        return $this->hasMany(ShiftTypeTask::class);
    }
}