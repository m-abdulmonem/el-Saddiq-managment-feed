<?php

namespace App\Http\Requests\Jobs;


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
        return [
            'name' => 'required|string|unique:jobs,name,' . $this->route("job")->id
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return parent::messages();
    }
}
