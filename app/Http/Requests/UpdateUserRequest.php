<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        // El usuario que estamos editando se pasa en la ruta
        $userId = $this->route('user')->id;
        $veterinarioId = $this->route('user')->veterinario ? $this->route('user')->veterinario->id : null;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:4',
            'especialidad' => 'nullable|string|max:255',
            'cedula_profesional' => $veterinarioId 
                ? 'nullable|string|max:255|unique:veterinarios,cedula_profesional,' . $veterinarioId
                : 'nullable|string|max:255|unique:veterinarios,cedula_profesional',
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
            
            'password.min' => 'La contraseña debe tener al menos 4 caracteres.',
            
            'especialidad.max' => 'La especialidad no puede tener más de 255 caracteres.',
            
            'cedula_profesional.unique' => 'Esta cédula profesional ya está registrada a nombre de otro veterinario.',
            'cedula_profesional.max' => 'La cédula profesional no puede tener más de 255 caracteres.',
        ];
    }
}
