<?php

namespace App\Http\Requests\Supplier\Supplier;

use Illuminate\Foundation\Http\FormRequest;

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

        $rules['name'] = "required|string|unique:suppliers,name,".$this->route("supplier")->id;

        return $rules;
    }

    /**
     * get the validation input names
     *
     * @return array
     */
    public function messages()
    {
        return parent::messages();
    }
}
