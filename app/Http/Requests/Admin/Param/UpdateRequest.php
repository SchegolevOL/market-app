<?php

namespace App\Http\Requests\Admin\Param;

use App\Enums\Param\ParamFilterTypeEnum;
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
            'param.title' => 'required|string',
            'param.category_id' => 'required|integer|exists:categories,id',
            'param.filter_type' => 'required|integer|in:' . ParamFilterTypeEnum::valuesAsString()
        ];
    }
    protected function passedValidation()
    {
        $validated = $this->validated();
        return $this->merge([
            'param'=> $validated['param'],

        ]);
    }
}
