<?php

namespace App\Http\Requests\Chicks\Orders;

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
            'name' => "required",
            'is_came' => 'required|boolean',
            'chick_id' => 'required|integer',
            'price' => "sometimes|nullable|numeric"
        ];
    }


    public function messages()
    {
        return [
            'name' => trans("$this->trans.name"),
            'is_came' => trans("$this->trans.status"),
            'chick_id' => trans("$this->trans.type"),
            'price' => trans("$this->trans.price"),
        ];
    }

}
