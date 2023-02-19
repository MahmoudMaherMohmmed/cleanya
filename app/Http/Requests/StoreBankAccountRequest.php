<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankAccountRequest extends FormRequest
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
            'bank_name' => 'required|array',
            'bank_name.*' => 'required|string|max:255',
            'account_name' => 'required',
            'account_number' => 'required',
            'IBAN' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
