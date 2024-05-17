<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'userid' => 'required|min:8',
            'password' => 'required|min:8'
        ];
    }
    public function messages()
    {
        return [
            'userid.required' => 'useridは、入力必須です',
            'password.required' => 'passwordは、入力必須です',
            'userid.min' => 'useridは、8文字以上です',
            'password.min' => 'passwordは、8文字以上です',
        ];
    }
}
