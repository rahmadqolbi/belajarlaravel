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
        'qty' => 'required|array',
        'qty.*' => 'required|numeric|min:1',
        'dibayar' => 'required|numeric|min:0',
        'produk_id' => 'required|array|min:1',
        'produk_id.*' => 'required|exists:produk,id',

        ];
    }
    public function attributes()
    {
        return [
            'dibayar' => 'Dibayar',
        ];
    }
    public function messages()
    {
        return [
            'dibayar' => ':attribute Wajib Di isi'
        ];
    }
}
