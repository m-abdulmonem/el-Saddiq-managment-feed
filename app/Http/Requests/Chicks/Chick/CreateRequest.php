<?php

namespace App\Http\Requests\Chicks\Chick;

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
            'name' => "required|unique:chicks",
            'type' => 'required|in:ducks,chick,chicken',
            'supplier_id' => "required|int"
        ];
    }

    public function messages()
    {
        return [
            'name' => trans("$this->trans.name"),
            'type' => trans("$this->trans.type"),
            'supplier_id' => trans("$this->trans.supplier")
        ];
    }
}
