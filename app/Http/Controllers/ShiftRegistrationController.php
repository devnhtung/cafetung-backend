<?php
// app/Http/Controllers/ShiftRegistrationController.php
namespace App\Http\Controllers;

use App\Models\ShiftRegistration;
use App\Models\PositionTask;
use App\Models\ShiftTypeTask;
use App\Models\ShiftRegistrationTask;
use Illuminate\Http\Request;

class ShiftRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'user_id' => 'required|exists:users,id',
            'position_id' => 'required|exists:positions,id',
        ]);

        $existingRegistration = ShiftRegistration::where('shift_id', $request->shift_id)
            ->where('user_id', $request->user_id)
            ->where('position_id', $request->position_id)
            ->first();

        if ($existingRegistration) {
            return response()->json(['message' => 'Bạn đã đăng ký ca này rồi!'], 400);
        }

        $approvedRegistration = ShiftRegistration::where('shift_id', $request->shift_id)
            ->where('position_id', $request->position_id)
            ->where('status', 'approved')
            ->first();

        if ($approvedRegistration) {
            return response()->json(['message' => 'Vị trí này đã được duyệt cho nhân viên khác!'], 400);
        }

        $registration = ShiftRegistration::create([
            'shift_id' => $request->shift_id,
            'user_id' => $request->user_id,
            'position_id' => $request->position_id,
            'status' => 'pending',
        ]);

        // Gán công việc mặc định từ vị trí
        $positionTasks = PositionTask::where('position_id', $request->position_id)->get();
        foreach ($positionTasks as $positionTask) {
            ShiftRegistrationTask::create([
                'shift_registration_id' => $registration->id,
                'task_id' => $positionTask->task_id,
                'is_custom' => false,
                'status' => 'pending',
            ]);
        }

        // Gán công việc mặc định từ loại ca
        $shift = $registration->shift;
        $shiftTypeTasks = ShiftTypeTask::where('shift_type_id', $shift->shift_type_id)->get();
        foreach ($shiftTypeTasks as $shiftTypeTask) {
            // Kiểm tra xem công việc đã được gán từ position chưa để tránh trùng lặp
            $existingTask = ShiftRegistrationTask::where('shift_registration_id', $registration->id)
                ->where('task_id', $shiftTypeTask->task_id)
                ->first();
            if (!$existingTask) {
                ShiftRegistrationTask::create([
                    'shift_registration_id' => $registration->id,
                    'task_id' => $shiftTypeTask->task_id,
                    'is_custom' => false,
                    'status' => 'pending',
                ]);
            }
        }

        return response()->json($registration, 201);
    }

    public function deleteTask($registrationId, $taskId)
    {
        try {
            // 1. Tìm đăng ký ca làm
            $registration = ShiftRegistration::find($registrationId);
            if (!$registration) {
                return response()->json([
                    'message' => 'Đăng ký ca làm không tồn tại.',
                ], 404);
            }

            // 2. Tìm công việc trong bảng trung gian shift_registration_tasks
            $shiftRegistrationTask = ShiftRegistrationTask::where('shift_registration_id', $registrationId)
                ->where('task_id', $taskId)
                ->first();

            if (!$shiftRegistrationTask) {
                return response()->json([
                    'message' => 'Công việc không tồn tại trong đăng ký ca làm này.',
                ], 404);
            }

            // 3. Kiểm tra công việc đã hoàn thành chưa
            if ($shiftRegistrationTask->completed_at) {
                return response()->json([
                    'message' => 'Không thể xóa công việc đã hoàn thành.',
                ], 403);
            }

            // 4. Xóa công việc
            $shiftRegistrationTask->delete();

            return response()->json([
                'message' => 'Xóa công việc thành công.',
            ], 200);
        } catch (\Exception $e) {
            // Ghi log lỗi để debug


            return response()->json([
                'message' => 'Xóa công việc thất bại.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function pending(Request $request)
    {
        $registrations = ShiftRegistration::with(['shift.shiftType', 'user.employeeDetails', 'position'])
            ->where('status', 'pending')
            ->get()
            ->map(function ($registration) {
                return [
                    'id' => $registration->id,
                    'shift_id' => $registration->shift_id,
                    'shift_date' => $registration->shift->date,
                    'shift_type' => $registration->shift->shiftType->name,
                    'employee_name' => $registration->user->employeeDetails->full_name ?? 'N/A',
                    'position_name' => $registration->position->name,
                    'status' => $registration->status,
                ];
            });

        return response()->json($registrations);
    }

    public function approve(Request $request, $id)
    {
        $registration = ShiftRegistration::findOrFail($id);

        $request->validate([
            'performance_rating' => 'nullable|integer|min:1|max:5',
            'manager_comments' => 'nullable|string',
        ]);

        $approvedRegistration = ShiftRegistration::where('shift_id', $registration->shift_id)
            ->where('position_id', $registration->position_id)
            ->where('status', 'approved')
            ->first();

        if ($approvedRegistration) {
            return response()->json(['message' => 'Vị trí này đã được duyệt cho nhân viên khác!'], 400);
        }

        $registration->update([
            'status' => 'approved',
            'performance_rating' => $request->performance_rating,
            'manager_comments' => $request->manager_comments,
        ]);

        return response()->json(['message' => 'Duyệt ca thành công!']);
    }

    public function reject($id)
    {
        $registration = ShiftRegistration::findOrFail($id);
        $registration->update(['status' => 'rejected']);
        return response()->json(['message' => 'Từ chối ca thành công!']);
    }

    public function checkIn($id)
    {
        $registration = ShiftRegistration::findOrFail($id);
        if ($registration->check_in_time) {
            return response()->json(['message' => 'Đã chấm công vào ca!'], 400);
        }

        $registration->update(['check_in_time' => now()]);
        return response()->json(['message' => 'Chấm công vào ca thành công!']);
    }

    public function checkOut($id)
    {
        $registration = ShiftRegistration::findOrFail($id);
        if (!$registration->check_in_time) {
            return response()->json(['message' => 'Chưa chấm công vào ca!'], 400);
        }
        if ($registration->check_out_time) {
            return response()->json(['message' => 'Đã chấm công ra ca!'], 400);
        }

        $registration->update(['check_out_time' => now()]);
        return response()->json(['message' => 'Chấm công ra ca thành công!']);
    }

    public function getTasks($id)
    {
        $registration = ShiftRegistration::with(['tasks.task'])->findOrFail($id);
        $tasks = $registration->tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'task_id' => $task->task_id,
                'name' => $task->task->name,
                'description' => $task->task->description,
                'is_custom' => $task->is_custom,
                'status' => $task->status,
                'completed_at' => $task->completed_at,
                'shift_registration_id' => $task->shift_registration_id,
            ];
        });

        // return response()->json($registration->tasks);
        return response()->json($tasks);
    }

    public function addTask(Request $request, $id)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);

        $registration = ShiftRegistration::findOrFail($id);

        $existingTask = ShiftRegistrationTask::where('shift_registration_id', $id)
            ->where('task_id', $request->task_id)
            ->first();

        if ($existingTask) {
            return response()->json(['message' => 'Công việc này đã được gán!'], 400);
        }

        $task = ShiftRegistrationTask::create([
            'shift_registration_id' => $id,
            'task_id' => $request->task_id,
            'is_custom' => true,
            'status' => 'pending',
        ]);

        return response()->json($task, 201);
    }

    public function completeTask($id, $taskId)
    {
        $task = ShiftRegistrationTask::where('shift_registration_id', $id)
            ->where('id', $taskId)
            ->firstOrFail();

        if ($task->status === 'completed') {
            return response()->json(['message' => 'Công việc đã hoàn thành!'], 400);
        }

        $task->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return response()->json(['message' => 'Hoàn thành công việc thành công!']);
    }
}
