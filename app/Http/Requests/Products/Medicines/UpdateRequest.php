<?php

namespace App\Http\Requests\Products\Medicines;

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
        $rules = parent::rules();

        $rules['name'] .= ',name,' .$this->route("medicine")->id;
        return $rules;
    }

    public function messages()
    {
        return parent::messages();
    }
}
