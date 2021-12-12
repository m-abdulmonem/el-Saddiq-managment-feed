<?php

namespace App\Http\Requests\Stock;

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

        $rules['name'] = 'required|string|unique:stocks,name,' . $this->route("stock")->id;

        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return parent::messages();
    }
}
