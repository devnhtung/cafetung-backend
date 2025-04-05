<?php
// app/Models/Shift.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['date', 'shift_type_id'];

    public function shiftType()
    {
        return $this->belongsTo(ShiftType::class);
    }

    public function registrations()
    {
        return $this->hasMany(ShiftRegistration::class);
    }
}
