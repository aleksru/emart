<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $slug = $this->route('product') ? ',' . $this->route('product')->slug . ',slug' : '';
        $sku = $this->route('product') ? ',' . $this->route('product')->sku . ',sku' : '';
        return [
            'category_id'       => 'required|integer',
            'manufacturer_id'   => 'nullable|integer',
            'sku'               => 'required|string|unique:products,sku' . $sku,
            'name'              => 'required|string',
            'slug'              => 'required|string|unique:products,slug' . $slug,
            'description'       => 'string|nullable',
            'price'             => 'numeric|required',
            'quantity'          => 'integer|required',
            'is_active'         => 'string|nullable',
            'sorting'           => 'integer|nullable|min:0',
            'seo'               => '',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
