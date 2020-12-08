<?php

namespace App\Http\Requests\ProductBrand;

use Illuminate\Foundation\Http\FormRequest;

class ProductBrandStoreRequest extends FormRequest
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
            'name' => 'required|min:3|unique:product_brands',
            'image' => 'required|mimes:jpg,png,jpeg|image'
        ];
    }
}
