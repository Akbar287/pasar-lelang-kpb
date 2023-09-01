<?php

namespace Database\Seeders;

use App\Models\JenisOpsiPembayaranLelang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisOpsiPembayaranLelangSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = JenisOpsiPembayaranLelang::count();

        if ($cek == 0) {
            $temp = [
                ["nama_jenis" => "Fee dibayar tunai"],
                ["nama_jenis" => "Fee potong pembayaran"],
                ["nama_jenis" => "Fee ditanggung pembeli"],
            ];

            foreach ($temp as $t) {
                $status = new JenisOpsiPembayaranLelang();
                $status->nama_jenis = $t['nama_jenis'];
                $status->save();
            }
        }
    }
}
