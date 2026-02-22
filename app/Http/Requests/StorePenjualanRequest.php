<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenjualanRequest extends FormRequest
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
        // 'qty.*' => 'required|numeric|min:1',
        //  'produk_id' => 'required|array',
        // 'produk_id.*' => 'required|exists:produk,id',
        // 'total' => 'required'
        ];
    }
    public function attributes()
    {
        return [
            // 'qty.*' => 'Qty',
            // 'produk_id' => 'Produk',
            // 'produk_id.*' => 'Produk'
        ];
    }
    public function messages()
    {
        return [
            // 'qty.*' => ':attribute Wajib Di isi',
            // 'produk_id.*' => ':attribute Wajib Di Isi'
        ];
    }
}
