<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

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
            'product.id'=>'required|exists:products,id',
            'product.product_group_id' => 'required|integer|exists:product_groups,id',
            'product.category_id' => 'required|integer|exists:categories,id',
            'product.title' => 'required|string|max:255',
            'product.description' => 'required|string',
            'product.content' => 'required|string',
            'product.price' => 'required|numeric',
            'product.parent_id' => 'nullable|integer|exists:products,id',
            'product.old_price' => 'numeric',
            'product.qty' => 'required|integer',
            'product.article' => 'required|string|unique:products,article,'. $this['product']['id'],
            'images'=>'nullable|array',
            'images.*' => 'required|file',
            'params' => 'nullable|array',
            'params.*.id' => 'required|integer|exists:params,id',
            'params.*.value' => 'required|string',
        ];
    }

    protected function passedValidation()
    {
        $validated = $this->validated();
        return $this->merge([
            'product'=> $validated['product'],
            'params' => $this->params ?? [],
            'images'=> $this->images ?? [],
        ]);
    }
}
