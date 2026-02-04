<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'nama_supplier' =>strtoupper(trim($this->nama_supplier)),
            'alamat' =>strtoupper(trim($this->alamat))
        ]);
    }
    public function rules(): array
    {
        return [
            'nama_supplier' => 'required|unique:supplier',
        ];

    }
    public function messages()
    {
        return [
            'required' => ':attribute Wajib Di Isi',
            'unique' => ':attribute Sudah Ada Sebelumnya',
        ];
    }
    public function attributes(){
        return [
            'nama_supplier' => 'Supplier',
        ];
    }

}
