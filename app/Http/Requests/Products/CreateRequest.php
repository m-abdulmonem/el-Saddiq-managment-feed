<?php

namespace App\Http\Requests\Products;

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
            'supplier_id' => 'required|integer',
            'category_id' => 'required|integer',
            'unit_id' => 'sometimes|required|integer',
            'notes' => 'sometimes|nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name' => trans("$this->trans.name"),
            'category_id' => trans("$this->trans.category"),
            'supplier_id' => trans("$this->trans.supplier"),
            'unit_id' => trans("$this->trans.unit"),
            'notes' => trans("$this->trans.notes"),
        ];
    }
}
