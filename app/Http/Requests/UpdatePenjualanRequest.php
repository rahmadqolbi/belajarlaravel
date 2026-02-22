<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenjualanRequest extends FormRequest
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
      $id = $this->route('id'); // ambil ID penjualan dari route
    return [
        'kode' => 'required|unique:penjualan,kode,' . $id, // pastikan TIDAK ada spasi sebelum $id
        'tanggal' => 'required|date',
        'dibayar' => 'required|numeric',
        'metode_pembayaran' => 'required|string',
        'produk_id.*' => 'required|exists:produk,id',
        'qty.*' => 'required|integer|min:1',
    ];
    }
}
