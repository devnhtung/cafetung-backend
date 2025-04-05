<?php
// app/Http/Requests/StoreEmployeeDetailRequest.php -->

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeDetailRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->role === 'admin' || $this->user()->role === 'manage';
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'full_name' => 'required|string|min:2|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            // 'phone_number' => 'nullable|string|regex:/^\d{10,11}$/',
            // 'address' => 'nullable|string|max:1000',
            // 'hire_date' => 'nullable|date|before_or_equal:today',
            // 'national_id' => 'nullable|string|regex:/^\d{9,12}$/',
            // 'bank_account' => 'nullable|string|max:255',
            // 'emergency_contact_name' => 'nullable|string|max:255',
            // 'emergency_contact_phone' => 'nullable|string|regex:/^\d{10,11}$/',
        ];
    }
}