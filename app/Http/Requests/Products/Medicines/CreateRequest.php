<?php

namespace App\Http\Requests\Products\Medicines;

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
            'name' => 'required|string|unique:medicines',
            'quantity' => 'required|integer',
            'sale_price' => 'required',
            'purchase_price' => 'required|regex:/^\d*(\.\d{2})?$/',
            'profit' => 'required|regex:/^\d*(\.\d{2})?$/',
            'stock_in' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name' => trans("$this->trans.name"),
            'quantity' => trans("$this->trans.quantity"),
            'sale_price' => trans("$this->trans.sale_price"),
            'purchase_price' => trans("$this->trans.purchase_price"),
            'profit' => trans("$this->trans.profit"),
            'store_in' => trans("$this->trans.store_in"),
        ];
    }
}
