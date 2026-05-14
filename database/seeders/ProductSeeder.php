<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'nama_barang' => 'Beras Pandan Wangi 5kg',
            'satuan' => 'karung',
            'harga_beli_default' => 75000,
            'margin_default' => 10000,
        ]);

        Product::create([
            'nama_barang' => 'Beras Setra Ramos 10kg',
            'satuan' => 'karung',
            'harga_beli_default' => 120000,
            'margin_default' => 25000,
        ]);

        Product::create([
            'nama_barang' => 'Gula Pasir GMP 1kg',
            'satuan' => 'pack',
            'harga_beli_default' => 14000,
            'margin_default' => 2500,
        ]);

        Product::create([
            'nama_barang' => 'Minyak Goreng Bimoli 2L',
            'satuan' => 'dus',
            'harga_beli_default' => 32000,
            'margin_default' => 6000,
        ]);
    }
}
