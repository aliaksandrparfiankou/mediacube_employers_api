<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class CompanyGetEmployeesRequest extends FormRequest
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
            'page_number' => 'integer|min:1',
            'count' => 'integer|min:1'
        ];
    }
}
