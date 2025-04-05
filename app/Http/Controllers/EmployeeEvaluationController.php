<?php
// app/Http/Controllers/EmployeeEvaluationController.php
namespace App\Http\Controllers;

use App\Models\EmployeeEvaluation;
use Illuminate\Http\Request;

class EmployeeEvaluationController extends Controller
{
    public function index()
    {
        $evaluations = EmployeeEvaluation::with(['user.employeeDetails'])->get()->map(function ($evaluation) {
            return [
                'id' => $evaluation->id,
                'user_id' => $evaluation->user_id,
                'employee_name' => $evaluation->user->employeeDetails->full_name ?? 'N/A',
                'evaluation_date' => $evaluation->evaluation_date,
                'rating' => $evaluation->rating,
                'comments' => $evaluation->comments,
            ];
        });
        return response()->json($evaluations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'evaluation_date' => 'required|date',
            'rating' => 'nullable|integer|min:1|max:5',
            'comments' => 'nullable|string',
            'evaluated_by' => 'required|exists:users,id',
        ]);

        $evaluation = EmployeeEvaluation::create($request->all());
        return response()->json($evaluation, 201);
    }
}
