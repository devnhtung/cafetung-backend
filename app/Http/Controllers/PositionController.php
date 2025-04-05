<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        $postions = Position::all();
        return response()->json($postions);
    }
    public function getTasks($id)
    {
        $position = Position::with(['tasks.task'])->findOrFail($id);
        $tasks = $position->tasks->map(function ($task) {
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
