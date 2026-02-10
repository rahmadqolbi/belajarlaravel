<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangMasukRequest extends FormRequest
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
        return [
                'tanggal' => 'required',
                'supplier_id' => 'required',
                'tujuan_type' => 'required',
                'no_dokumen' => 'required',
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
            'tujuan_id' => 'Tujuan',
            'no_dokumen' => 'No Dokumen',
            'keterangan' => 'Keterangan',
        ];
    }
}
