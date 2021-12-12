<?php

namespace App\Http\Requests\Products;

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
        return parent::rules();
//        $rules =  parent::rules();

//        $rules['name'] = "required|unique:products,name," . $this->route("product")->id;
//
//        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return parent::messages();
    }
}
