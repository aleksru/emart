<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Category\Entities\Category;

class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        ///'slug' => 'required|unique:airlines,slug' . $slug,
        $slug = $this->route('category') ? ',' . $this->route('category')->slug . ',slug' : '';
        return [
            'parent_id' => 'integer|nullable',
            'name'      => 'required|string',
            'slug'      => 'required|string|unique:categories,slug' . $slug,
            'description' => 'string|nullable',
            'ordering'  => 'integer|nullable|min:0',
            'is_active'  => 'string|nullable',
            'seo'  => '',
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
