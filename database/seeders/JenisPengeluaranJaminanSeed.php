<?php

namespace Database\Seeders;

use App\Models\JenisPengeluaranJaminan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisPengeluaranJaminanSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = JenisPengeluaranJaminan::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_jenis" => "Release Cash Collateral"
                ],
                [
                    "nama_jenis" => "Release Commodity Collateral"
                ],
                [
                    "nama_jenis" => "Return Cash Collateral"
                ],
            ];

            foreach ($temp as $t) {
                $status = new JenisPengeluaranJaminan();
                $status->nama_jenis = $t['nama_jenis'];
                $status->save();
            }
        }
    }
}
