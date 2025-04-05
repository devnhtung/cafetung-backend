<?php
// app/Models/ShiftTypeTask.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftTypeTask extends Model
{
    protected $fillable = ['shift_type_id', 'task_id'];

    public function shiftType()
    {
        return $this->belongsTo(ShiftType::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
