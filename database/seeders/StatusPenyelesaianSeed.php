<?php

namespace Database\Seeders;

use App\Models\StatusPenyelesaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusPenyelesaianSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = StatusPenyelesaian::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_jenis" => "Transaksi Berhasil"
                ],
                [
                    "nama_jenis" => "Transaksi Gagal"
                ],
                [
                    "nama_jenis" => "Transaksi Pending"
                ],
            ];

            foreach ($temp as $t) {
                $status = new StatusPenyelesaian();
                $status->nama_jenis = $t['nama_jenis'];
                $status->save();
            }
        }
    }
}
