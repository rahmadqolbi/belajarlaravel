<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGudangRequest extends FormRequest
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
<<<<<<< HEAD
             'kode_gudang' => strtoupper(trim($this->kode_gudang)),
=======
>>>>>>> 41a3d1c28cbbb6acb7860ed9bdf8c1e730385982
            'nama_gudang' => strtoupper(trim($this->nama_gudang)),
            'alamat' => strtoupper(trim($this->alamat)),
            'penanggung_jawab' => strtoupper(trim($this->penanggung_jawab)),
        ]);
    }
    public function rules(): array
    {
        return [
            'nama_gudang' => 'required',
            'alamat' => 'required',
            'penanggung_jawab' => 'required',
            'telepon' => 'required',
            'status' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute Wajib Di Isi',
        ];
    }
    public function attributes()
    {
        return [
            'nama_gudang' => 'Nama Gudang',
            'alamat' => 'Alamat Gudang',
            'penanggung_jawab' => 'Penanggung Jawab',
            'telepon' => 'Telepon',
            'status' => 'Status',
            'alamat' => 'Alamat'
        ];
    }
}
