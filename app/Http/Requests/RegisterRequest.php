<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'=>'required',
            'username'=>'required',
            'birthday'=>'required',
            'address'=>'required',
            'password'=>'required',
            'phone'=>'required',
            'confirm-password'=>'required',
            'nickname'=>'required',
            'agree'=>'accepted',
        ];
    }
    public function message()
    {
        return [
            'required'=>'This box cannot be left blank',
            'accepted'=>'Please tick this field'
        ];
    }
}
