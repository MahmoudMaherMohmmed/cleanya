<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'title' => 'required|array',
            'title.*' => 'required|string',
            'description' => 'required|array',
            'description.*' => 'required|string',
            'phone_1' => 'required|numeric',
            'phone_2' => 'required|numeric',
            'email_1' => 'required|email',
            'email_2' => 'required|email',
            'working_days' => 'required|array',
            'from' => 'required',
            'to' => 'required',
            'tax' => 'required|min:0',
            'facebook_link' => 'required',
            'whatsapp_link' => 'required',
            'instagram_link' => 'required',
            'api_url' => 'required|url',
            'api_key' => 'required|string|max:255',
            'api_username' => 'required|string|max:255',
            'api_password' => 'required|string|max:255',
            'lat' => 'required',
            'lng' => 'required',
            'logo' => 'required|mimes:jpeg,png,jpg,svg',
        ];
    }
}
