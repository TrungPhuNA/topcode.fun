<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckEmailRequest extends FormRequest
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

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => 'fail_validate',
            'message' => 'Validation errors',
            'data'    => $validator->errors()
        ]));
    }

    public function rules()
    {
        return [
            'service'     => 'required|in:PAYPAL,MOMO,VNPAY',
            'status' => 'required',
        ];
    }
}
