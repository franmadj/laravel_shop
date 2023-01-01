<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return $this->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required|max:255|unique:users,name,'.$this->user->id,
            'email' => 'required|email:rfc|unique:users,email,'.$this->user->id,//,dns
            //'password' => 'required|confirmed|max:255',
            'role' => 'required|in:super admin,admin'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'password.required' => 'La constraseña es obligatoria',
            'role.required' => 'Selecciona un role',
        ];
    }

}
