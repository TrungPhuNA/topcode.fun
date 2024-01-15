<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name'     => 'required',
            'email'    => 'required|unique:users,email,' . $this->id,
            'phone'    => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.unique'      => 'Email đã tồn tại',
            'name.required'     => 'Tên không được để trống',
            'email.required'    => 'Email không được để trống',
            'phone.required'    => 'Phone không được để trống',
            'password.required' => 'Password không được để trống',
        ];
    }
}
