<?php

namespace App\Http\Requests;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8|max:255',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'moto' => 'nullable|string|min:3|max:255',
            'id_role' => 'required|exists:role,id_role',
            'id_instansi' => 'nullable|exists:instansi,id_instansi'
        ];
    }
}
