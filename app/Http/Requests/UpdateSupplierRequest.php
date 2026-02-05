<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'nama_supplier' => strtoupper(trim($this->nama_supplier))
        ]);
    }
    public function rules(): array
    {

        $id = $this->route('id');
        return [
            'nama_supplier' => "required|unique:supplier,nama_supplier,$id",
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
