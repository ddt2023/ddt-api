<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));

    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|max:100',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ad mütləq daxil edilməlidir',
            'surname.required' => 'Soyad mütləq daxil edilməlidir',
            'phone.required' => 'Telefon nömrəsi mütləq daxil edilməlidir',
            'phone.numeric' => 'Telefon nömrəsi ancaq rəqəm olmalıdır',
            'email.required' => 'Email ünvanı mütləq daxil edilməlidir',
            'email.email' => 'Email ünvanı doğru formatda olmalıdır',
            'email.max' => 'Email ünvanı 100 xarakteri keçməməlidir',
        ];
    }
}
