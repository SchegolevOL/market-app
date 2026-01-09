<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'category.title' => 'required|string|max:255',
            'category.parent_id' => 'nullable|integer|exists:categories,id',
            'images'=>'nullable|array',
            'images.*' => 'required|file',
        ];
    }
    protected function passedValidation()
    {

        $validated = $this->validated();

        return $this->merge([
            'category'=> $validated['category'],
            'images'=> $this->images ?? [],
        ]);
    }

}
