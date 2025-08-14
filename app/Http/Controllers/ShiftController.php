<?php
// app/Http/Controllers/ShiftController.php
namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\ShiftRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function getEmployeeShifts(Request $request, $userId)
    {
        // Validate the request
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $date = $request->query('date');

        // Ensure the authenticated user can only access their own shifts (unless they are an admin)
        // $authUser = Auth::user();
        // if ($authUser->role !== 'admin' && $authUser->id != $userId) {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        // Fetch shift registrations for the user on the specified date
        $shiftRegistrations = ShiftRegistration::with(['shift.shiftType', 'user'])
            ->where('user_id', $userId)
            ->whereHas('shift', function ($query) use ($date) {
                $query->where('date', $date);
            })
            ->get()
            ->map(function ($registration) {
                $shift = $registration->shift;
                $shiftType = $shift->shiftType;

                // Combine shift date with shift type start/end times
                $startTime = $shift->date . ' ' . $shiftType->start_time;
                $endTime = $shift->date . ' ' . $shiftType->end_time;

                return [
                    'id' => $registration->id,
                    'shift_id' => $shift->id,
                    'user_id' => $registration->user_id,
                    'check_in_time' => $registration->check_in_time ? $registration->check_in_time->toISOString() : null,
                    'check_out_time' => $registration->check_out_time ? $registration->check_out_time->toISOString() : null,
                    'status' => $registration->status,
                    'shift' => [
                        'id' => $shift->id,
                        'date' => $shift->date,
                        'name' => $shiftType->name,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'created_at' => $shift->created_at->toISOString(),
                        'updated_at' => $shift->updated_at->toISOString(),
                    ],
                ];
            });

        return response()->json($shiftRegistrations);
    }
}