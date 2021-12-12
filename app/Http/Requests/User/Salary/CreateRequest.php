<?php

namespace App\Http\Requests\User\Salary;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'salary' => 'sometimes|required',
            'increase' => 'sometimes|nullable',
            'discount' => 'sometimes|nullable',
            'notes' => 'sometimes|nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'salary' => trans("$this->trans.salary"),
            'increase' => trans("$this->trans.increase"),
            'discount' => trans("$this->trans.discount"),
            'notes' => trans("$this->trans.notes"),
        ];
    }
}
