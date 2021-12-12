<?php

namespace App\Http\Requests\Chicks\Chick;

use App\Models\Chick;

class UpdateRequest extends CreateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['name'] = "required|unique:chicks,name," . $this->route("chick")->id;

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
