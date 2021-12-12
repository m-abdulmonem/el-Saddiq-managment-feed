<?php

namespace App\Http\Requests\Clients\Invoices;

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
            'client_id' => 'required|integer',
            'discount' => 'sometimes|nullable',
            'debt' => 'sometimes|nullable|in:cash,postpaid',
            'status' => 'required|in:draft,loaded,onWay,delivered,canceled',
            'postpaid' => 'sometimes|nullable',
            'notes' => 'sometimes|nullable|string',
            'products' => 'required|array',
            'quantity' => 'required|array',
            'unitPrice' => 'required|array',
            'price' => 'required|array',
        ];
    }

    public function excepted()
    {
        $new  = [
            'quantity' => $this->total_quantity,
            'price' => $this->total_price,
        ];
        return self::$excepted = array_merge($this->except(['unitPrice','price','stock_id']),$new);
    }

    public function messages()
    {
        return [
            'client_id' =>trans("$this->trans.client"),
            'discount' => trans("suppliers_bills.discount"),
            'debt' => trans("suppliers_bills.debt"),
            'status' => trans("$this->trans.status"),
            'postpaid' =>trans("$this->trans.paid"),
            'notes' => trans("$this->trans.notes"),
            'products' => trans("products.product"),
            'quantity' => trans("products.count"),
            'unitPrice' => trans("products.unit_price"),
            'price' =>trans("products.total_price"),
        ];
    }
}
