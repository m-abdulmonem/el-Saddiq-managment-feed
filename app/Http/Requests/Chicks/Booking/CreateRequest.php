<?php

namespace App\Http\Requests\Chicks\Booking;

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
            'phone' => 'required|numeric',
            'order_id' => 'required|integer',
            'chick_id' => 'sometimes|nullable|integer',
            'quantity' => "required|numeric",
            'deposit' => "required|numeric"
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name' => trans("$this->trans.name"),
            'phone' => trans("$this->trans.phone"),
            'order_id' => trans("$this->trans.order_id"),
            'chick_id' => trans("$this->trans.chick_id"),
            'quantity' => trans("$this->trans.quantity"),
            'deposit' => trans("$this->trans.deposit"),
        ];
    }
}
