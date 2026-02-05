<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
                'alamat' => 'required',
                'agama' => 'required',
                'nohp'   => 'required|numeric|min:12|unique:aktifitas',
        ];
    }
    public function messages()
    {
        return[
            'required' => ':attribute Wajib Di isi',
            'numeric'  => ':attribute Berupa Angka',
            'min' => ':attribute minimal :min digit',
            'unique' => ':attribute Sudah Ada Sebelumnya'
            ];
    }
     public function attributes()
    {
        return [
            'nama_kategori' => 'Nama Kategori',
            'kode' => 'Kode Barang'
        ];
    }
}
