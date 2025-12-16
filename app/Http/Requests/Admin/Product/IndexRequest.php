<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class IndexRequest extends FormRequest
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
            'product_group_title' => 'nullable|string',
            'category_title' => 'nullable|string',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'price_from' => 'nullable|numeric',
            'price_to' => 'nullable|numeric',
            'old_price_from' => 'nullable|numeric',
            'old_price_to' => 'nullable|numeric',
            'qty_from' => 'nullable|integer',
            'qty_to' => 'nullable|integer',
            'article' => 'nullable|string',
            'created_at_from' => 'nullable|date_format:Y-m-d',
            'created_at_to' => 'nullable|date_format:Y-m-d',
            'updated_at_from' => 'nullable|date_format:Y-m-d',
            'updated_at_to' => 'nullable|date_format:Y-m-d',
            'param_title_value'=>'nullable|array',
            'per_page'=>'nullable|integer',
            'page'=>'nullable|integer',
        ];
    }
    protected function passedValidation()
    {
        return $this->merge([

            'per_page' => $this->per_page ?? 5,
            'page' => $this->page ?? 1,
        ]);
    }
}

