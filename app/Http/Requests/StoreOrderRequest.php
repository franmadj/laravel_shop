<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|email',
            'address' => 'required|max:255',
            'suite' => 'nullable|max:40',
            'town' => 'required|max:20',
            'state' => 'required|max:20',
            'pc' => 'required|max:10',
            'phone' => 'required|max:15',
            'notes' => 'nullable|max:255',
            'cart_items' => 'required|array',
            'cart_total' => 'required|numeric',

        ];
    }
}
