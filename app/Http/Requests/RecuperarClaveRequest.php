<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecuperarClaveRequest extends FormRequest
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
            "password" => "required",
            "passwordRepeat" => "required"
        ];
    }
    public function messages()
    {
        return [
            "password.required" => "Debe llenar el campo 'nueva contraseña'",
            "passwordRepeat.required" => "Debe llenar el campo 'repetir nueva contraseña'"
        ];
    }
}
