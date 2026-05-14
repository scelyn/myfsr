<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_barang' => ['required', 'string', 'max:150', 'min:3'],
            'satuan'      => ['required', 'string', 'max:50'],
            'harga_beli_default'  => ['required', 'numeric', 'min:0'],
            'margin_default'  => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.min'      => 'Nama barang minimal 3 karakter.',
            'satuan.required'      => 'Satuan wajib dipilih.',
            'harga_beli_default.required'  => 'Harga beli default wajib diisi.',
            'harga_beli_default.min'       => 'Harga beli default tidak boleh negatif.',
            'margin_default.required'  => 'Margin default wajib diisi.',
            'margin_default.min'       => 'Margin default tidak boleh negatif.',
        ];
    }
}
