<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->role === 'admin' || $this->user()->role === 'manage';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:staff,manage,admin',
            'phone' => 'nullable|string|regex:/^\d{10,11}$/',
            'address' => 'nullable|string|max:1000',
            'position_id' => 'required|exists:positions,id',
        ];
    }
}
