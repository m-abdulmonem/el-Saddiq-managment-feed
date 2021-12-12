<?php

namespace App\Http\Requests\Clients\Client;

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
            'name' => 'required|string|unique:clients',
            'phone' => 'sometimes|nullable|numeric',
            'trader' => 'required|in:true,false',
            'address' => 'required|string',
            'discount' => 'sometimes|nullable|numeric',
            'credit_limit' => 'sometimes|nullable|regex:/^\d*(\.\d{2})?$/',
            'maximum_repayment_period' => 'sometimes|nullable|integer',
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
            'trader' => trans("$this->trans.trader"),
            'address' => trans("$this->trans.address"),
            'discount' => trans("$this->trans.discount"),
        ];
    }
}
