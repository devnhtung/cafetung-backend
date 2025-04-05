<?php
// app/Models/EmployeeEvaluation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeEvaluation extends Model
{
    protected $fillable = [
        'user_id',
        'evaluation_date',
        'rating',
        'comments',
        'evaluated_by',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }
}
