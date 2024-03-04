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
        return $this->user()->hasRole(['admin','user']);
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
            'password' => 'nullable|confirmed|max:255',
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|max:12|unique:users,phone,'.$this->user->id,
            'bio' => 'nullable|max:255',
            'photo'=>'nullable|image'
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
            'password.required' => 'La constraseña no es valida',
            'role.required' => 'Selecciona un role',
        ];
    }

}
