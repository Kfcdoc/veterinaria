<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'rol' => 'required|in:administrador,veterinario',
            'especialidad' => 'nullable|string|max:255',
            'cedula_profesional' => 'nullable|string|max:255|unique:veterinarios,cedula_profesional',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre completo es obligatorio.',
            'name.string' => 'El nombre debe ser un texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes proporcionar un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado en el sistema.',
            
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres.',
            
            'rol.required' => 'Debes seleccionar un rol (Administrador o Veterinario).',
            'rol.in' => 'El rol seleccionado no es válido.',
            
            'especialidad.max' => 'La especialidad no puede tener más de 255 caracteres.',
            
            'cedula_profesional.unique' => 'Esta cédula profesional ya está registrada a nombre de otro veterinario.',
            'cedula_profesional.max' => 'La cédula profesional no puede tener más de 255 caracteres.',
        ];
    }
}
