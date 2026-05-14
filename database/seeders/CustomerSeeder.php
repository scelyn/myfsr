<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['nama_toko' => 'Toko Berkah Utama',    'nama_pemilik' => 'Haji Ahmad',   'no_whatsapp' => '081234567890', 'alamat_pasar' => 'Pasar Induk Kramat Jati, Blok A-10'],
            ['nama_toko' => 'Warung Pojok Makmur',  'nama_pemilik' => 'Ibu Siti',     'no_whatsapp' => '085712345678', 'alamat_pasar' => 'Pasar Rebo, Samping Terminal'],
            ['nama_toko' => 'Toko Jaya Abadi',      'nama_pemilik' => 'Pak Budi',     'no_whatsapp' => '082198765432', 'alamat_pasar' => 'Pasar Minggu, Los C-5'],
            ['nama_toko' => 'Kios Surya Sembako',   'nama_pemilik' => 'Dewi Lestari', 'no_whatsapp' => '087865432100', 'alamat_pasar' => 'Pasar Senen, Blok III'],
            ['nama_toko' => 'UD Maju Bersama',      'nama_pemilik' => 'Bapak Hendra', 'no_whatsapp' => '081387654321', 'alamat_pasar' => 'Pasar Jatinegara, Kios 12'],
        ];

        foreach ($customers as $data) {
            Customer::create($data);
        }
    }
}
