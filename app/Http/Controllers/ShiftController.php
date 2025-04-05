<?php
// app/Http/Controllers/ShiftController.php
namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $shifts = Shift::with(['shiftType', 'registrations.user.employeeDetails', 'registrations.position'])
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->map(function ($shift) {
                return [
                    'id' => $shift->id,
                    'date' => $shift->date,
                    'shiftType' => $shift->shiftType,
                    'registrations' => $shift->registrations->map(function ($registration) {
                        return [
                            'id' => $registration->id,
                            'user_id' => $registration->user_id,
                            'employee_name' => $registration->user->employeeDetails->full_name ?? 'N/A',
                            'position_id' => $registration->position_id,
                            'position_name' => $registration->position->name,
                            'status' => $registration->status,
                            'check_in_time' => $registration->check_in_time,
                            'check_out_time' => $registration->check_out_time,
                        ];
                    }),
                ];
            });

        return response()->json($shifts);
    }

    public function store(Request $request)
    {
        $shift = Shift::create($request->all());
        return response()->json($shift, 201);
    }
}
