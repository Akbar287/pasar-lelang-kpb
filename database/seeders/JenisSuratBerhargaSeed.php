<?php

namespace Database\Seeders;

use App\Models\JenisSuratBerharga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSuratBerhargaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = JenisSuratBerharga::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_jenis" => "Saham",
                    "keterangan" => "Saham"
                ],
                [
                    "nama_jenis" => "Deposito",
                    "keterangan" => "Deposito"
                ],
                [
                    "nama_jenis" => "Obligasi",
                    "keterangan" => "Obligasi"
                ],
                [
                    "nama_jenis" => "Resi Gudang",
                    "keterangan" => "Resi Gudang"
                ],
            ];

            foreach ($temp as $t) {
                $status = new JenisSuratBerharga();
                $status->nama_jenis = $t['nama_jenis'];
                $status->keterangan = $t['keterangan'];
                $status->save();
            }
        }
    }
}
