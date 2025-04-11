<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstansiRequest extends FormRequest
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
            'nama' => 'required|string|max:255|unique:instansi,nama' . ($id ? ',' . $id . ',id_instansi' : ''),
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'profile' => $id ? 'nullable|image|mimes:jpg,jpeg,png|max:2048' : 'required|image|mimes:jpg,jpeg,png|max:2048',
            'background' => $id ? 'required|string|max:255' : 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama instansi wajib diisi!',
            'nama.string' => 'Nama instansi harus berupa teks!',
            'nama.max' => 'Nama instansi maksimal 255 karakter!',
            'nama.unique' => 'Nama instansi sudah terdaftar, gunakan nama lain!',

            'alamat.required' => 'Alamat instansi wajib diisi!',
            'alamat.string' => 'Alamat harus berupa teks!',
            'alamat.max' => 'Alamat maksimal 255 karakter!',

            'deskripsi.required' => 'Deskripsi instansi wajib diisi!',
            'deskripsi.string' => 'Deskripsi harus berupa teks!',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter!',

            'profile.required' => 'Foto profil wajib diunggah!',
            'profile.image' => 'File harus berupa gambar!',
            'profile.mimes' => 'Format yang diperbolehkan hanya JPG, JPEG, PNG!',
            'profile.max' => 'Ukuran maksimal gambar adalah 2MB!',

            'background.required' => 'Background wajib diunggah!',
            'background.image' => 'File harus berupa gambar!',
            'background.mimes' => 'Format yang diperbolehkan hanya JPG, JPEG, PNG!',
            'background.max' => 'Ukuran maksimal gambar adalah 2MB!',
        ];
    }
}
