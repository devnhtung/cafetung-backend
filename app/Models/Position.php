<?php
// app/Models/Position.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function Tasks()
    {
        return $this->hasMany(PositionTask::class);
    }

    public function shiftRegistrations()
    {
        return $this->hasMany(ShiftRegistration::class);
    }
}
