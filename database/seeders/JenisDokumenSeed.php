<?php

namespace Database\Seeders;

use App\Models\JenisDokumen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisDokumenSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = JenisDokumen::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_jenis" => "KTP",
                    "keterangan" => "Dokumen Ktp"
                ],
                [
                    "nama_jenis" => "SIM",
                    "keterangan" => "Dokumen Sim"
                ],
                [
                    "nama_jenis" => "Passport",
                    "keterangan" => "Dokumen Passport"
                ],
            ];

            foreach ($temp as $t) {
                $status = new JenisDokumen();
                $status->nama_jenis = $t['nama_jenis'];
                $status->keterangan = $t['keterangan'];
                $status->save();
            }
        }
    }
}
