<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'categories' => [
                'required',
                'array',
                function ($attribute, $categories, $fail) {
                    $count = Category::whereIn('id', $categories)->count();
                    if (count($categories) != $count) {
                        $fail('The ' . $attribute . ' is invalid.');
                    }
                },
            ],
            'title' => 'required|max:255|unique:products,title',
            'content' => 'nullable',
            'slug' => 'required|max:255|unique:products,slug',
            'status' => 'required|in:published,draft',
            'type' => 'required|in:simple,variable',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'stock_quantity' => 'nullable|numeric',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'body.required' => 'A message is required',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    /* protected function prepareForValidation()
{
$this->merge([
'slug' => Str::slug($this->slug),
]);
} */
}
