<?php

namespace App\Http\Requests\User;


class UpdateRequest extends CreateRequest
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
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'holidays' => 'sometimes|nullable|string',
            'salary' => 'required|integer',
            'salary_type' => 'required|in:daily,monthly',
            'job_id' => 'required|integer',
            'is_active' => 'sometimes|nullable|boolean',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return parent::messages();
    }
}
