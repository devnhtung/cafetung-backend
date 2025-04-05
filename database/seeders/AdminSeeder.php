<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EmployeeDetails;
use App\Models\Position;
use App\Models\ShiftType;
use App\Models\Shift;
use App\Models\Task;
use App\Models\PositionTask;
use App\Models\ShiftTypeTask;
use App\Models\ShiftRegistration;
use App\Models\ShiftRegistrationTask;
use App\Models\Attendance;
use App\Models\EmployeeEvaluation;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Thêm người dùng (users)
        $users = [
            ['name' => 'lepn', 'email' => 'lepn@example.com', 'password' => bcrypt('password'), 'role' => 'staff'],
            ['name' => 'minhtrang', 'email' => 'minhtrang@example.com', 'password' => bcrypt('password'), 'role' => 'staff'],
            ['name' => 'quanghuy', 'email' => 'quanghuy@example.com', 'password' => bcrypt('password'), 'role' => 'staff'],
            ['name' => 'Staff User', 'email' => 'thanhnga@example.com', 'password' => bcrypt('password'), 'role' => 'staff'],
            ['name' => 'Quản lý User', 'email' => 'manager1@example.com', 'password' => bcrypt('password'), 'role' => 'manage'],
            ['name' => 'Quản lý User', 'email' => 'manager2@example.com', 'password' => bcrypt('password'), 'role' => 'manage'],
        ];

        $createdUsers = [];
        foreach ($users as $userData) {
            $createdUsers[] = User::create($userData);
        }

        // 2. Thêm thông tin chi tiết nhân viên (employee_details)
        $employeeDetails = [
            [
                'user_id' => $createdUsers[0]->id,
                'full_name' => 'Lê P. Nhí',
                'date_of_birth' => Carbon::parse('1995-05-15'),
                'gender' => 'female',
                'phone_number' => '0905123456',
                'address' => '123 Đường Láng, Hà Nội',
                'hire_date' => Carbon::parse('2023-01-10'),
                'national_id' => '123456789',
                'bank_account' => '1234567890 - Vietcombank',
                'emergency_contact_name' => 'Nguyễn Văn A',
                'emergency_contact_phone' => '0987654321',
            ],
            [
                'user_id' => $createdUsers[1]->id,
                'full_name' => 'Minh Trang',
                'date_of_birth' => Carbon::parse('1998-08-20'),
                'gender' => 'female',
                'phone_number' => '0905987654',
                'address' => '456 Nguyễn Trãi, TP.HCM',
                'hire_date' => Carbon::parse('2023-02-15'),
                'national_id' => '987654321',
                'bank_account' => '0987654321 - Techcombank',
                'emergency_contact_name' => 'Trần Thị B',
                'emergency_contact_phone' => '0912345678',
            ],
            [
                'user_id' => $createdUsers[2]->id,
                'full_name' => 'Quang Huy',
                'date_of_birth' => Carbon::parse('1997-03-12'),
                'gender' => 'male',
                'phone_number' => '0912345678',
                'address' => '789 Lê Lợi, Đà Nẵng',
                'hire_date' => Carbon::parse('2023-03-01'),
                'national_id' => '456789123',
                'bank_account' => '4567891234 - BIDV',
                'emergency_contact_name' => 'Lê Thị C',
                'emergency_contact_phone' => '0933445566',
            ],
            [
                'user_id' => $createdUsers[3]->id,
                'full_name' => 'Thanh Nga',
                'date_of_birth' => Carbon::parse('1996-11-25'),
                'gender' => 'female',
                'phone_number' => '0923456789',
                'address' => '321 Trần Phú, Nha Trang',
                'hire_date' => Carbon::parse('2023-04-10'),
                'national_id' => '321654987',
                'bank_account' => '3216549870 - Vietinbank',
                'emergency_contact_name' => 'Phạm Văn D',
                'emergency_contact_phone' => '0944556677',
            ],
            [
                'user_id' => $createdUsers[4]->id,
                'full_name' => 'Nguyễn Văn Quản Lý 1',
                'date_of_birth' => Carbon::parse('1990-03-10'),
                'gender' => 'male',
                'phone_number' => '0905111222',
                'address' => '789 Lê Lợi, Đà Nẵng',
                'hire_date' => Carbon::parse('2022-01-01'),
                'national_id' => '111222333',
                'bank_account' => '1112223334 - BIDV',
                'emergency_contact_name' => 'Lê Thị C',
                'emergency_contact_phone' => '0933445566',
            ],
            [
                'user_id' => $createdUsers[5]->id,
                'full_name' => 'Trần Thị Quản Lý 2',
                'date_of_birth' => Carbon::parse('1988-07-20'),
                'gender' => 'female',
                'phone_number' => '0905222333',
                'address' => '654 Nguyễn Huệ, Huế',
                'hire_date' => Carbon::parse('2022-02-01'),
                'national_id' => '222333444',
                'bank_account' => '2223334445 - Agribank',
                'emergency_contact_name' => 'Nguyễn Văn E',
                'emergency_contact_phone' => '0955667788',
            ],
        ];

        foreach ($employeeDetails as $detail) {
            EmployeeDetails::create($detail);
        }

        // 3. Thêm vị trí (positions)
        $positions = ['Phục vụ', 'Pha chế', 'Thu ngân', 'Trưởng ca', 'Thử việc', 'Giữ xe'];
        $createdPositions = [];
        foreach ($positions as $position) {
            $createdPositions[] = Position::create(['name' => $position]);
        }

        // 4. Thêm loại ca (shift types)
        $shiftTypes = [
            ['name' => 'Sáng', 'start_time' => '06:00:00', 'end_time' => '12:00:00'],
            ['name' => 'Chiều', 'start_time' => '12:00:00', 'end_time' => '15:00:00'],
            ['name' => 'Tối', 'start_time' => '15:00:00', 'end_time' => '22:00:00'],
        ];
        $createdShiftTypes = [];
        foreach ($shiftTypes as $shiftType) {
            $createdShiftTypes[] = ShiftType::create($shiftType);
        }

        // 5. Thêm công việc (tasks)
        $tasks = [
            ['name' => 'Dọn bàn', 'description' => 'Dọn dẹp và sắp xếp bàn ăn sạch sẽ'],
            ['name' => 'Pha chế đồ uống', 'description' => 'Chuẩn bị các loại đồ uống theo yêu cầu'],
            ['name' => 'Kiểm tra tiền mặt', 'description' => 'Kiểm tra và đối chiếu tiền mặt cuối ca'],
            ['name' => 'Chào đón khách', 'description' => 'Chào đón và hướng dẫn khách vào bàn'],
            ['name' => 'Kiểm tra hàng tồn', 'description' => 'Kiểm tra số lượng hàng tồn kho'],
            ['name' => 'Hỗ trợ đồng nghiệp', 'description' => 'Hỗ trợ các nhân viên khác khi cần'],
            ['name' => 'Chuẩn bị nguyên liệu', 'description' => 'Chuẩn bị nguyên liệu cho ca làm'],
            ['name' => 'Lau dọn khu vực bếp', 'description' => 'Dọn dẹp khu vực bếp sạch sẽ'],
            ['name' => 'Kiểm tra vệ sinh', 'description' => 'Kiểm tra và dọn dẹp khu vực nhà hàng'],
            ['name' => 'Ghi nhận doanh thu', 'description' => 'Ghi nhận doanh thu cuối ca'],
        ];
        $createdTasks = [];
        foreach ($tasks as $task) {
            $createdTasks[] = Task::create($task);
        }

        // 6. Gán công việc cho vị trí (position_tasks)
        $positionTasks = [
            ['position_id' => $createdPositions[0]->id, 'task_id' => $createdTasks[0]->id], // phục vụ - Dọn bàn
            ['position_id' => $createdPositions[0]->id, 'task_id' => $createdTasks[3]->id], // phục vụ - Chào đón khách
            ['position_id' => $createdPositions[1]->id, 'task_id' => $createdTasks[1]->id], // pha chế - Pha chế đồ uống
            ['position_id' => $createdPositions[1]->id, 'task_id' => $createdTasks[6]->id], // pha chế - Chuẩn bị nguyên liệu
            ['position_id' => $createdPositions[2]->id, 'task_id' => $createdTasks[2]->id], // thu ngân - Kiểm tra tiền mặt
            ['position_id' => $createdPositions[2]->id, 'task_id' => $createdTasks[9]->id], // thu ngân - Ghi nhận doanh thu
            ['position_id' => $createdPositions[3]->id, 'task_id' => $createdTasks[4]->id], // trưởng ca - Kiểm tra hàng tồn
            ['position_id' => $createdPositions[3]->id, 'task_id' => $createdTasks[5]->id], // trưởng ca - Hỗ trợ đồng nghiệp
            ['position_id' => $createdPositions[4]->id, 'task_id' => $createdTasks[6]->id], // bếp - Chuẩn bị nguyên liệu
            ['position_id' => $createdPositions[4]->id, 'task_id' => $createdTasks[7]->id], // bếp - Lau dọn khu vực bếp
            ['position_id' => $createdPositions[5]->id, 'task_id' => $createdTasks[8]->id], // vệ sinh - Kiểm tra vệ sinh
        ];
        foreach ($positionTasks as $positionTask) {
            PositionTask::create($positionTask);
        }

        // 7. Gán công việc cho loại ca (shift_type_tasks)
        $shiftTypeTasks = [
            ['shift_type_id' => $createdShiftTypes[0]->id, 'task_id' => $createdTasks[4]->id], // Sáng - Kiểm tra hàng tồn
            ['shift_type_id' => $createdShiftTypes[1]->id, 'task_id' => $createdTasks[6]->id], // Chiều - Chuẩn bị nguyên liệu
            ['shift_type_id' => $createdShiftTypes[2]->id, 'task_id' => $createdTasks[2]->id], // Tối - Kiểm tra tiền mặt
        ];
        foreach ($shiftTypeTasks as $shiftTypeTask) {
            ShiftTypeTask::create($shiftTypeTask);
        }

        // 8. Thêm ca làm (shifts) cho 14 ngày
        $startDate = Carbon::parse('2025-03-24');
        $shifts = [];
        for ($i = 0; $i < 14; $i++) {
            $date = $startDate->copy()->addDays($i);
            foreach ($createdShiftTypes as $shiftType) {
                $shifts[] = Shift::create([
                    'date' => $date,
                    'shift_type_id' => $shiftType->id,
                ]);
            }
        }

        // 9. Thêm đăng ký ca (shift_registrations)
        $shiftRegistrations = [];
        $employees = array_slice($createdUsers, 0, 4); // Chỉ lấy nhân viên (không lấy quản lý)
        foreach ($shifts as $shift) {
            // Mỗi ca có 2-3 nhân viên đăng ký
            $numRegistrations = rand(2, 3);
            $selectedEmployees = array_rand($employees, $numRegistrations);
            if (!is_array($selectedEmployees)) {
                $selectedEmployees = [$selectedEmployees];
            }

            foreach ($selectedEmployees as $employeeIndex) {
                $employee = $employees[$employeeIndex];
                $position = $createdPositions[array_rand($createdPositions)];
                $status = $shift->date->isPast() ? 'approved' : 'pending';
                $checkInTime = $status === 'approved' && $shift->date->isPast()
                    ? Carbon::parse($shift->date)->setTimeFromTimeString($shift->shiftType->start_time)
                    : null;
                $checkOutTime = $status === 'approved' && $shift->date->isPast()
                    ? Carbon::parse($shift->date)->setTimeFromTimeString($shift->shiftType->end_time)
                    : null;
                $performanceRating = $status === 'approved' && $shift->date->isPast() ? rand(3, 5) : null;
                $managerComments = $status === 'approved' && $shift->date->isPast() ? 'Làm việc tốt' : null;

                $registration = ShiftRegistration::create([
                    'shift_id' => $shift->id,
                    'user_id' => $employee->id,
                    'position_id' => $position->id,
                    'status' => $status,
                    'check_in_time' => $checkInTime,
                    'check_out_time' => $checkOutTime,
                    'performance_rating' => $performanceRating,
                    'manager_comments' => $managerComments,
                ]);
                $shiftRegistrations[] = $registration;

                // 10. Gán công việc cho đăng ký ca (shift_registration_tasks)
                // Công việc từ vị trí
                $positionTasks = PositionTask::where('position_id', $position->id)->get();
                foreach ($positionTasks as $positionTask) {
                    $status = $shift->date->isPast() ? 'completed' : 'pending';
                    $completedAt = $status === 'completed' ? $checkOutTime : null;
                    ShiftRegistrationTask::create([
                        'shift_registration_id' => $registration->id,
                        'task_id' => $positionTask->task_id,
                        'is_custom' => false,
                        'status' => $status,
                        'completed_at' => $completedAt,
                    ]);
                }

                // Công việc từ loại ca
                $shiftTypeTasks = ShiftTypeTask::where('shift_type_id', $shift->shift_type_id)->get();
                foreach ($shiftTypeTasks as $shiftTypeTask) {
                    $existingTask = ShiftRegistrationTask::where('shift_registration_id', $registration->id)
                        ->where('task_id', $shiftTypeTask->task_id)
                        ->first();
                    if (!$existingTask) {
                        $status = $shift->date->isPast() ? 'completed' : 'pending';
                        $completedAt = $status === 'completed' ? $checkOutTime : null;
                        ShiftRegistrationTask::create([
                            'shift_registration_id' => $registration->id,
                            'task_id' => $shiftTypeTask->task_id,
                            'is_custom' => false,
                            'status' => $status,
                            'completed_at' => $completedAt,
                        ]);
                    }
                }

                // Công việc bổ sung (10% khả năng có công việc bổ sung)
                if (rand(1, 100) <= 10) {
                    $randomTask = $createdTasks[array_rand($createdTasks)];
                    $existingTask = ShiftRegistrationTask::where('shift_registration_id', $registration->id)
                        ->where('task_id', $randomTask->id)
                        ->first();
                    if (!$existingTask) {
                        $status = $shift->date->isPast() ? 'completed' : 'pending';
                        $completedAt = $status === 'completed' ? $checkOutTime : null;
                        ShiftRegistrationTask::create([
                            'shift_registration_id' => $registration->id,
                            'task_id' => $randomTask->id,
                            'is_custom' => true,
                            'status' => $status,
                            'completed_at' => $completedAt,
                        ]);
                    }
                }

                // 11. Thêm chấm công (attendances)
                if ($status === 'approved' && $shift->date->isPast()) {
                    $attendanceStatus = rand(1, 100) <= 90 ? 'completed' : 'late';
                    Attendance::create([
                        'user_id' => $employee->id,
                        'shift_registration_id' => $registration->id,
                        'check_in_time' => $checkInTime,
                        'check_out_time' => $checkOutTime,
                        'status' => $attendanceStatus,
                    ]);
                }
            }
        }

        // 12. Thêm đánh giá nhân viên (employee_evaluations)
        $managers = array_slice($createdUsers, 4, 2); // Chỉ lấy quản lý
        foreach ($employees as $employee) {
            // Mỗi nhân viên có 1-2 đánh giá
            $numEvaluations = rand(1, 2);
            for ($i = 0; $i < $numEvaluations; $i++) {
                $evaluationDate = Carbon::parse('2025-03-24')->subDays(rand(30, 90));
                EmployeeEvaluation::create([
                    'user_id' => $employee->id,
                    'evaluation_date' => $evaluationDate,
                    'rating' => rand(3, 5),
                    'comments' => 'Làm việc tốt, cần cải thiện kỹ năng giao tiếp',
                    'evaluated_by' => $managers[array_rand($managers)]->id,
                ]);
            }
        }
    }
}