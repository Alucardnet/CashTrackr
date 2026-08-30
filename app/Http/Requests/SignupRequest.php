<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Override;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    #[Override]
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El E-mail es obligatorio',
            'email.email' => 'E-mail no valido',
            'email.unique' => 'Este correo ya ha sido registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe tener al menos :min caracteres',
            'password.letters' => 'La contraseña debe de contener al menos una letra',
            'password.mixed'=> 'La contraseña debe de contener al menos 1 letra mayuscula y 1 letra minúscula',
            'password.symbols' => 'La contraseña debe de contener al menos 1 caracter especial (#+*$%&-.)',
            'password.numbers' => 'La contraseña debe de contener al menos 1 número',
            'password.uncompromised' => 'La contraseña ha aparecido en filtraciones de datos. Elige una mas segura'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->symbols()
                    ->numbers()
                    ->uncompromised()
            ]
        ];
    }
}
