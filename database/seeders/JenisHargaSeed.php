<?php

namespace Database\Seeders;

use App\Models\JenisHarga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisHargaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = JenisHarga::count();
        if ($cek == 0) {
            $temp = [
                [
                    "nama_jenis_harga" => "Penawaran Untuk Semua Volume Barang"
                ],
                [
                    "nama_jenis_harga" => "Penawaran Pada Harga Satuan"
                ]
            ];

            foreach ($temp as $t) {
                $status = new JenisHarga();
                $status->nama_jenis_harga = $t['nama_jenis_harga'];
                $status->save();
            }
        }
    }
}
