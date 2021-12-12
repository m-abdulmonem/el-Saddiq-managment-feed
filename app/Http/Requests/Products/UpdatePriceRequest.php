<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'price' => 'required',
            'sale_price' => 'required',
        ];
    }


    public function authorize()
    {
        return true;
    }
}
