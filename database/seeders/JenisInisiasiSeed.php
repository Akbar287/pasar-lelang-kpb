<?php

namespace Database\Seeders;

use App\Models\JenisInisiasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisInisiasiSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = JenisInisiasi::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_inisiasi" => "Inisiasi Jual",
                    "keterangan" => "Inisiasi untuk melelang produk",
                    "is_aktif" => true
                ],
                [
                    "nama_inisiasi" => "Inisiasi Beli",
                    "keterangan" => "Inisiasi untuk membeli lelang produk",
                    "is_aktif" => true
                ],
                [
                    "nama_inisiasi" => "Bid Jual",
                    "keterangan" => "Bid untuk melelang produk",
                    "is_aktif" => true
                ],
                [
                    "nama_inisiasi" => "Bid Beli",
                    "keterangan" => "Bid untuk membeli lelang produk",
                    "is_aktif" => true
                ],
            ];

            foreach ($temp as $t) {
                $status = new JenisInisiasi();
                $status->nama_inisiasi = $t['nama_inisiasi'];
                $status->keterangan = $t['keterangan'];
                $status->is_aktif = $t['is_aktif'];
                $status->save();
            }
        }
    }
}
