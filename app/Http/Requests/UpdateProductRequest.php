<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'title'=>'required|max:255|unique:products,title,'.$this->product->id,
            'content'=>'nullable',
            'slug' => 'required|max:255|unique:products,slug,'.$this->product->id,
            'status' => 'required|in:published,draft',
            'type' => 'required|in:simple,variable',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'stock_quantity' => 'nullable|numeric'
        ];
    }
}
