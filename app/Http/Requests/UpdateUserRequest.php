<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    // public function authorize()
    // {
    //     return $this->user()->role === 'admin' || $this->user()->role === 'manage';
    // }

    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email',
            'role' => 'required|in:staff,manage,admin',
            'phone' => 'nullable|string|regex:/^\d{10,11}$/',
            'address' => 'nullable|string|max:1000',
            'position_id' => 'required|exists:positions,id',
        ];
    }
}
