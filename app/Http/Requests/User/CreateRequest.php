<?php

namespace App\Http\Requests\User;

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
            'name' => 'required|string',
            'username' => 'sometimes|nullable|string|unique:users|min:4' ,
            'email' => 'sometimes|nullable|email|unique:users',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'holidays' => 'sometimes|nullable|string',
            'salary' => 'required|integer',
            'salary_type' => 'required|in:daily,monthly',
            'job_id' => 'required|integer',
            'is_active' => 'sometimes|nullable|boolean',
            'password'=> 'sometimes|nullable|string|confirmed|min:6',
            'credit_limit' => 'sometimes|nullable|regex:/^\d*(\.\d{2})?$/',
            'discount_limit' => 'sometimes|nullable|regex:/^\d*(\.\d{2})?$/',
        ];
    }

    /**
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name' => trans("$this->trans.name"),
            'username' => trans("$this->trans.username"),
            'email' => trans("$this->trans.email"),
            'phone' => trans("$this->trans.phone"),
            'address' => trans("$this->trans.address"),
            'holidays' => trans("$this->trans.holiday_days"),
            'salary' => trans("$this->trans.salary"),
            'salary_type' => trans("$this->trans.pay_type"),
            'job_id' => trans("$this->trans.job"),
            'is_active' => trans("$this->trans.status"),
            'password' => trans("login.password"),
        ];
    }
}
