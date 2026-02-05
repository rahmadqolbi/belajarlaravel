<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriRequest extends FormRequest
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
            'nama_kategori' => strtoupper(trim($this->nama_kategori))
        ]);
    }
    public function rules(): array
    {
         return [
            'nama_kategori' => ['required', 'unique:users, nama_kategori,'.$this->id]
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute Wajib Di Isi',
             'unique' => ':attribute Sudah Ada Sebelumnya'
        ];
    }

    public function attributes()
    {
        return [
            'nama_kategori' => 'Nama Kategori'
        ];
    }
}
