<?php

namespace App\Http\Requests\Supplier\Bills;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{

    public static $excepted = [];

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
            "supplier_id" => "required|integer",
            "driver" => "sometimes|nullable|string",
            "discount" => "sometimes|nullable|numeric",
            "number" => "sometimes|nullable|numeric",
            "notes" => "sometimes|nullable|string",
            "product_id" => "required|array",
            "stock" => "required|nullable|array",
            "quantity" => "required|nullable|array",
            "prices" => "required|nullable|array",
            "sale_price" => "required|nullable|array",
            "price" => "required|integer",
        ];
    }


    public function excepted()
    {
        $keys = ['product_id','query','stock','quantity','prices','sale_price','expired_at'];

        return self::$excepted = $this->except($keys);
    }

    public function messages()
    {
        return [
            "supplier_id" => trans("suppliers.name"),
            "driver" => trans("$this->trans.driver"),
            "discount" => trans("$this->trans.discount"),
            "number" => trans("$this->trans.bill_number"),
            "notes" => trans("$this->trans.notes"),
            "product_id" => trans("products.name"),
            "stock" => trans("stocks.name"),
            "quantity" => trans("$this->trans.quantity"),
            "prices" => trans("products/history.ton_price"),
            "sale_price" => trans("products.price"),
            "price" => trans("products.price"),
        ];
    }
}
