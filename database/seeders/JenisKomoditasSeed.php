<?php

namespace Database\Seeders;

use App\Models\JenisKomoditas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisKomoditasSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = JenisKomoditas::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_jenis_komoditas" => "Resi Gudang",
                    "keterangan" => "Komoditas ini memiliki resi gudang",
                    "is_aktif" => true
                ],
                [
                    "nama_jenis_komoditas" => "Non-Resi Gudang",
                    "keterangan" => "Komoditas ini tidak memiliki resi gudang",
                    "is_aktif" => true
                ],
            ];

            foreach ($temp as $t) {
                $status = new JenisKomoditas();
                $status->nama_jenis_komoditas = $t['nama_jenis_komoditas'];
                $status->keterangan = $t['keterangan'];
                $status->is_aktif = $t['is_aktif'];
                $status->save();
            }
        }
    }
}
