<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuRequest extends FormRequest
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
            'penerbit' => 'required|string|max:255',
            'alamat_penerbit' => 'required|string|max:255',
            'judul' => 'required|string|max:255|unique:buku,judul',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'jumlah_halaman' => 'required|integer|min:1',
            'sampul' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'deskripsi' => 'required|string',
            'file_buku' => 'nullable|file|mimes:pdf|max:10240',
            'total_download' => 'nullable|integer|min:0',
            'total_read' => 'nullable|integer|min:0',
            'uploaded_by' => 'required|uuid|exists:users,id_user',
            'sub_kelompok' => 'required|uuid|exists:sub_kelompok,id_sub_kelompok',
            'jenis' => 'required|uuid|exists:jenis,id_jenis',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.unique' => 'Judul buku sudah terdaftar, gunakan judul lain!',
            'tahun_terbit.digits' => 'Tahun terbit harus terdiri dari 4 angka!',
            'jumlah_halaman.min' => 'Jumlah halaman harus lebih dari 0!',
            'sampul.required' => 'Sampul wajib diunggah!',
            'sampul.image' => 'File sampul harus berupa gambar!',
            'file_buku.mimes' => 'File buku harus dalam format PDF!',
        ];
    }
}
