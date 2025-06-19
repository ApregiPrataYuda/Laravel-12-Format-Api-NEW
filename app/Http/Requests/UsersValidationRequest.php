<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            // 'password' => 'required|string|min:6',
            // 'role'     => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah digunakan.',
            // 'password.required' => 'Password wajib diisi.',
            // 'password.min'      => 'Password minimal 6 karakter.',
            // 'role.required'     => 'Role wajib diisi.'
        ];
    }
}
