<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShiftType;

class ShiftTypeController extends Controller
{
    public function index()
    {
        $shift_types = ShiftType::orderBy('start_time')->get();
        return response()->json($shift_types);
    }

    public function getTasks($id)
    {
        $shift_type = ShiftType::with(['tasks.task'])->findOrFail($id);
        // return $shift_type->tasks;
        $tasks = $shift_type->tasks->map(function ($task) {
            return [
                'id' => $task->id,
                // 'task_id' => $task->task_id,
                'name' => $task->task->name,
                'description' => $task->task->description,
                // 'is_custom' => $task->is_custom,
                // 'status' => $task->status,
                // 'completed_at' => $task->completed_at,
                // 'shift_registration_id' => $task->shift_registration_id,
            ];
        });

        return response()->json($tasks);
    }
}
