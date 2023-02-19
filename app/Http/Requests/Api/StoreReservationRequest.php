<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreReservationRequest extends FormRequest
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
            'reception_address_id' => 'required|exists:addresses,id',
            'reception_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'reception_time' => 'required',
            'sending_address_id' => 'required|exists:addresses,id',
            'sending_date' => 'required|date_format:Y-m-d|after:reception_date',
            'sending_time' => 'required',
            'payment_type' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('dashboard');
    }

    /**
     * failedValidation
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => false, 'message' => $validator->errors()->first(), 'data' => $validator->errors()], 403));
    }
}
