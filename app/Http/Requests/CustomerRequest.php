<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->customer?->id;

        return [
            'nama_toko'    => ['required', 'string', 'max:150'],
            'nama_pemilik' => ['required', 'string', 'max:150'],
            'no_whatsapp'  => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s]+$/',
            ],
            'alamat_pasar' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_toko.required'    => 'Nama toko wajib diisi.',
            'nama_pemilik.required' => 'Nama pemilik wajib diisi.',
            'no_whatsapp.required'  => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex'     => 'Format nomor WhatsApp tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_toko'    => 'Nama Toko',
            'nama_pemilik' => 'Nama Pemilik',
            'no_whatsapp'  => 'Nomor WhatsApp',
            'alamat_pasar' => 'Alamat Pasar',
        ];
    }
}
