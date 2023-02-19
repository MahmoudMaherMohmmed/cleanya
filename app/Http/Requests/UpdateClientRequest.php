<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'username'      => 'required|min:3',
            'email'     => 'required|unique:clients,email,'.$this->client->id,
            'phone'     => 'required|unique:clients,phone,'.$this->client->id,
            'lat'  => 'sometimes',
            'lng' => 'sometimes',
            'image' => 'mimes:jpeg,png,jpg,svg',
        ];
    }
}
