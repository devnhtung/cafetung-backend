<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->role === 'staff';
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'background_image' => 'required|string',
            'button_link' => 'nullable|url',
            'button_text' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'order' => 'integer'
        ];
    }
}
