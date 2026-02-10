<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangMasukRequest extends FormRequest
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
            'supplier_id' => strtoupper(trim($this->supplier_id)),
            'tujuan_type' => strtoupper(trim($this->tujuan_type)),
            'no_dokumen' => strtoupper(trim($this->no_dokumen)),
            'keterangan' => strtoupper(trim($this->keterangan)),
        ]);
    }
    public function rules(): array
    {
        $id = $this->route('id');
        return [
                'tanggal' => 'required',
                'supplier_id' => 'required',
                'tujuan_type' => 'required',
                'no_dokumen' => "required|unique:barangmasuk,no_dokumen, $id",
                'keterangan' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute Wajib Di Isi'
        ];
    }
    public function attributes()
    {
        return [
            'tanggal' => 'Tanggal',
            'supplier_id' => 'Supplier',
            'tujuan_type' => 'Tujuan',
            'no_dokumen' => 'No Dokumen',
            'keterangan' => 'Keterangan',
        ];
    }
}
