<?php

namespace App\Http\Requests\Transactions\Payments;

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
            'payment' => 'sometimes|required|in:cash,cheque',
            'payment_type' => 'sometimes|required|in:expenses,bank_deposit,pay_for_supplier',
            'paid' => 'required',
            'bill_id' => 'sometimes|nullable|integer',
            'client_bill_id' => 'sometimes|nullable|integer',
            'balance_id' => 'sometimes|nullable|integer',
            'supplier_id' => 'sometimes|nullable|integer',
            'bank_id' => 'sometimes|nullable|integer',
            'expense_id' => 'sometimes|nullable|integer',
            'client_id' => 'sometimes|nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'payment' => trans("$this->trans.payment"),
            'payment_type' => trans("$this->trans.payment_type"),
            'paid' => trans("$this->trans.paid"),
            'bill_id' => trans("suppliers/bills.title"),
            'client_bill_id' => trans("clients/bills.title"),
            'balance_id' => trans("balances.title"),
            'supplier_id' => trans("suppliers/suppliers.title"),
            'bank_id' => trans("transactions/banks.title"),
            'expense_id' => trans("transactions/expenses.title"),
            'client_id' => trans("clients/clients.title"),
        ];
    }
}
