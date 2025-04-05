<?php
// app/Http/Controllers/EmployeeController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmployeeDetails;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreEmployeeDetailRequest;
use App\Http\Requests\UpdateEmployeeDetailRequest;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::with('employeeDetails')
            ->where('role', 'staff')
            ->whereHas('employeeDetails')
            ->get()
            ->map(function ($user) {
                if ($user->employeeDetails && $user->employeeDetails->full_name)
                    return [
                        'id' => $user->id,
                        'name' => $user->employeeDetails->full_name,
                    ];
            });
        return response()->json($employees);
    }

    public function details()
    {
        $employees = User::with('employeeDetails')
            ->where('role', 'employee')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role,
                    'full_name' => $user->employeeDetails->full_name ?? 'N/A',
                    'date_of_birth' => $user->employeeDetails->date_of_birth,
                    'gender' => $user->employeeDetails->gender,
                    'phone_number' => $user->employeeDetails->phone_number,
                    'address' => $user->employeeDetails->address,
                    'hire_date' => $user->employeeDetails->hire_date,
                    'national_id' => $user->employeeDetails->national_id,
                    'bank_account' => $user->employeeDetails->bank_account,
                    'emergency_contact_name' => $user->employeeDetails->emergency_contact_name,
                    'emergency_contact_phone' => $user->employeeDetails->emergency_contact_phone,
                ];
            });
        return response()->json($employees);
    }

    public function getDetails()
    {
        $users = User::whereIn('role', ['staff', 'manage', 'admin'])
            ->with(['employeeDetails', 'position'])
            ->get();

        $formattedUsers = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone,
                'address' => $user->address,
                'position_id' => $user->position_id,
                'position_name' => $user->position ? $user->position->name : null,
                'employee_detail' => $user->employeeDetails ? [
                    'id' => $user->employeeDetails->id,
                    'user_id' => $user->employeeDetails->user_id,
                    'full_name' => $user->employeeDetails->full_name,
                    'date_of_birth' => $user->employeeDetails->date_of_birth ? $user->employeeDetails->date_of_birth->toDateString() : null,
                    'gender' => $user->employeeDetails->gender,
                    'phone_number' => $user->employeeDetails->phone_number,
                    'address' => $user->employeeDetails->address,
                    'hire_date' => $user->employeeDetails->hire_date ? $user->employeeDetails->hire_date->toDateString() : null,
                    'national_id' => $user->employeeDetails->national_id,
                    'bank_account' => $user->employeeDetails->bank_account,
                    'emergency_contact_name' => $user->employeeDetails->emergency_contact_name,
                    'emergency_contact_phone' => $user->employeeDetails->emergency_contact_phone,
                    'created_at' => $user->employeeDetails->created_at ? $user->employeeDetails->created_at->toDateTimeString() : null,
                    'updated_at' => $user->employeeDetails->updated_at ? $user->employeeDetails->updated_at->toDateTimeString() : null,
                ] : null,
            ];
        });

        return response()->json($formattedUsers);
    }

    /**
     * Thêm nhân viên mới (tạo user trước, sau đó tạo employee_detail)
     */
    public function store(StoreUserRequest $request)
    {
        $userData = $request->validated();

        // Tạo user mới
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'role' => $userData['role'],
            'phone' => $userData['phone'] ?? null,
            'address' => $userData['address'] ?? null,
            'position_id' => $userData['position_id'],
        ]);

        return response()->json([
            'data' => $user,
            'message' => 'Tạo tài khoản nhân viên thành công.',
        ], 201);
    }

    /**
     * Cập nhật thông tin đăng nhập (bảng users)
     */
    public function updateUser(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        // return response()->json($user);

        if (!$user) {
            return response()->json([
                'message' => 'Người dùng không tồn tại.',
            ], 404);
        }

        $userData = $request->validated();
        $user->update($userData);

        return response()->json($user);
    }

    /**
     * Thêm thông tin chi tiết nhân viên (bảng employee_details)
     */
    public function storeDetail(StoreEmployeeDetailRequest $request)
    {
        $data = $request->validated();

        $employeeDetail = EmployeeDetails::create($data);

        return response()->json([
            'data' => $employeeDetail,
            'message' => 'Thêm thông tin chi tiết nhân viên thành công.',
        ], 201);
    }

    /**
     * Cập nhật thông tin chi tiết nhân viên (bảng employee_details)
     */
    public function updateDetail(UpdateEmployeeDetailRequest $request, $id)
    {
        $employeeDetail = EmployeeDetails::find($id);

        if (!$employeeDetail) {
            return response()->json([
                'message' => 'Thông tin chi tiết nhân viên không tồn tại.',
            ], 404);
        }

        $data = $request->validated();
        $employeeDetail->update($data);

        return response()->json([
            'data' => $employeeDetail,
            'message' => 'Cập nhật thông tin chi tiết nhân viên thành công.',
        ], 200);
    }

    /**
     * Xóa nhân viên (xóa cả user và employee_detail)
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Người dùng không tồn tại.',
            ], 404);
        }
        $user->delete();

        return response()->json([
            'message' => 'Xóa nhân viên thành công.',
        ], 200);
    }
}
