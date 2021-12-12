<?php

namespace App\Http\Requests\Transactions\Banks;


class UpdateRequest extends CreateRequest
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
        $rules =  parent::rules();

        $rules['name'] = 'required|string|unique:banks,name,'.$this->route("bank")->id;
        return $rules;
    }

    public function messages()
    {
        return parent::messages();
    }
}
