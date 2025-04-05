<?php
// app/Models/PositionTask.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionTask extends Model
{
    protected $fillable = ['position_id', 'task_id'];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
