<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubKelompokRequest extends FormRequest
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
        $id = $this->route('subkelompok');
        return [
            'nama' => 'required|string|max:255|unique:sub_kelompok,nama,' . $id . ',id_sub_kelompok',
            'id_kelompok' => 'required|exists:kelompok,id_kelompok'
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama subkelompok wajib diisi!',
            'nama.string' => 'Nama subkelompok harus berupa teks!',
            'nama.max' => 'Nama subkelompok maksimal 255 karakter!',
            'nama.unique' => 'Nama subkelompok sudah terdaftar, gunakan nama lain!',
            'id_kelompok.required' => 'Kelompok wajib dipilih!',
            'id_kelompok.exists' => 'Kelompok yang dipilih tidak valid!'
        ];
    }
}
