<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'representative_id' => 'required|exists:clients,id',
            'reception_address_id' => 'required|exists:addresses,id',
            'reception_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'reception_time' => 'required',
            'sending_address_id' => 'required|exists:addresses,id',
            'sending_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'sending_time' => 'required',
            'delivery_cost' => 'required|min:0',
            'service_ids' => 'required|array',
            'service_ids.*' => 'required|exists:services,id',
            'cloth_ids' => 'required|array',
            'cloth_ids.*' => 'required|exists:clothes,id',
            'pieces_numbers' => 'required|array',
            'pieces_numbers.*' => 'required|integer',
        ];
    }
}
