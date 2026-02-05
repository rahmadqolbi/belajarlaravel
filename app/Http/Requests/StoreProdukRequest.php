<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukRequest extends FormRequest
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
   protected function prepareForValidation()
    {
        $this->merge([
            'kode' => strtoupper(trim($this->kode)),
            'nama_barang' => strtoupper(trim($this->nama_barang))
        ]);
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|unique:produk',
            'nama_barang' => 'required|unique:produk',
            'harga' => 'required|int',
            'kategori_id' => 'required'
        ];
    }
    public function messages()
    {
        return [
        'required' => ':attribute Wajib Di Isi',
        'unique'   => ':attribute Sudah Ada Sebelumnya',
        'integer'      => ':attribute Wajib Berupa Angka',
         'kategori_id.required' => 'Kategori wajib dipilih',
        ];
    }
    public function attributes(){
        return [
        'kode' => 'Kode Barang',
        'nama_barang' => 'Nama Barang',
        'harga' => 'Harga'
        ];

    }
}
