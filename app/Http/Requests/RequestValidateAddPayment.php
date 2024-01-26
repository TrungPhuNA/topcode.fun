<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class RequestValidateAddPayment extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'service'       => 'required|in:PAYPAL,MOMO,VNPAY',
            'partner_code'  => 'required',
            'service_data'  => 'required',
            'identifier_id' => 'required',
            'language'      => 'required',
            'amount'        => 'required',
            'url_success'   => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        Log::info($validator->getMessageBag());
        throw new HttpResponseException(response()->json([
            'status'  => 'fail_validate',
            'message' => 'Validation errors',
            'data'    => $validator->errors()
        ]));
    }
}
