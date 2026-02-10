<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutletRequest extends FormRequest
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
             'kode_outlet' => strtoupper(trim($this->kode_outlet)),
            'nama_outlet' => strtoupper(trim($this->nama_outlet)),
            'alamat' => strtoupper(trim($this->alamat)),
            'penanggung_jawab' => strtoupper(trim($this->penanggung_jawab)),
        ]);
    }
    public function rules(): array
    {
        return [
            'kode_outlet' => 'required',
            'nama_outlet' => 'required',
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
            'kode_outlet' => 'Kode Outlet',
            'nama_outlet' => 'Nama Outlet',
            'alamat' => 'Alamat Outlet',
            'penanggung_jawab' => 'Penanggung Jawab',
            'telepon' => 'Telepon',
            'status' => 'Status',
            'alamat' => 'Alamat'
        ];
    }
}
