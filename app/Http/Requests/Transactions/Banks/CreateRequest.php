<?php

namespace App\Http\Requests\Transactions\Banks;

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
            'name' => 'required|string|unique:banks',
            'opening_balance' => 'sometimes|nullable|min:0',
            'address' => 'sometimes|nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'name' => trans("$this->trans.name"),
            'opening_balance' => trans("$this->trans.opening_balance"),
            'address' => trans("$this->trans.address"),
        ];
    }
}
