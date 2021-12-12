<?php

namespace App\Http\Requests\Transactions\Receipts;

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
            'payment' => 'sometimes|required|in:cash,bank',
            'paid' => 'required',
            'bill_id' => 'sometimes|nullable|integer',
            'invoice_id' => 'sometimes|nullable|integer',
            'balance_id' => 'sometimes|nullable|integer',
            'bank_id' => 'sometimes|nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'payment' => trans("$this->trans.payment"),
            'paid' => trans("$this->trans.paid"),
            'bill_id' => trans("suppliers/bills.title"),
            'invoice_id' => trans("clients/bills.title"),
            'balance_id' => trans("balances.title"),
            'bank_id' => trans("transactions/banks.title"),
        ];
    }
}
