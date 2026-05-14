<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'order_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            
            // Items validation
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:1'],
            'items.*.notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom messages
     */
    public function messages(): array
    {
        return [
            'items.required' => 'Minimal harus menambahkan 1 produk ke dalam pesanan.',
            'items.min' => 'Minimal harus menambahkan 1 produk ke dalam pesanan.',
            'items.*.quantity.min' => 'Jumlah produk tidak boleh kurang dari 0.01.',

        ];
    }
}
