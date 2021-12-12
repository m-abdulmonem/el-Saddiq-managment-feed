<?php

namespace App\Http\Requests\Supplier\Supplier;

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
            'name' => 'required|string|unique:suppliers',
            'phone' => 'required|numeric',
            'my_code' => 'sometimes|nullable|numeric',
            'address' => 'required|string',
            'discount' => 'sometimes|nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name' => trans("$this->trans.name"),
            'phone' => trans("$this->trans.phone"),
            'my_code' => trans("$this->trans.my_code"),
            'address' => trans("$this->trans.address"),
            'discount' => trans("$this->trans.discount"),
        ];
    }
}
