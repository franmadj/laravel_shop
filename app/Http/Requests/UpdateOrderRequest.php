<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'buyer_details.first_name' => 'required|max:30',
            'buyer_details.last_name' => 'required|max:30',
            'buyer_details.email' => 'required|email',
            'buyer_details.address' => 'required|max:255',
            'buyer_details.suite' => 'nullable|max:40',
            'buyer_details.town' => 'required|max:20',
            'buyer_details.state' => 'required|max:20',
            'buyer_details.pc' => 'required|max:10',
            'buyer_details.phone' => 'required|max:15',
            'buyer_details.notes' => 'nullable|max:255',
            
            'status'=>'required|in:pending,processing,completed,cancelled'

        ];
    }
}
