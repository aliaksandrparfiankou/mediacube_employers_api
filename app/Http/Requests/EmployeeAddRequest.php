<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use App\Http\Enums\GenderEnum;
use Illuminate\Validation\Rule;

class EmployeeAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|between:1,32',
            'last_name' => 'required|string|between:1,64',
            'middle_name' => 'string|between:1,64',
            'gender' => [
                Rule::in(GenderEnum::toArray())
            ],
            'salary' => 'integer|min:0',
            'department_ids' => 'required|array',
            'department_ids.*' => 'integer|min:1',
        ];
    }
}
