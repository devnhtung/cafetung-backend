<?php
// app/Http/Requests/StorePostCategoryRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->role === 'staff';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:post_categories,name,' . ($this->category ?? ''),
            'description' => 'nullable|string',
        ];
    }
}
