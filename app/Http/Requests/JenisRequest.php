<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JenisRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'nama' => 'required|string|max:255|unique:jenis,nama,' . $id . ',id_jenis',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama jenis buku wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'nama.unique' => 'Nama jenis buku sudah ada, silakan gunakan yang lain.',
        ];
    }
}
