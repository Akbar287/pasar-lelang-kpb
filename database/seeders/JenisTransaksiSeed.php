<?php

namespace Database\Seeders;

use App\Models\JenisTransaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisTransaksiSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = JenisTransaksi::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_jenis" => "Cash / Bank In (Trading)",
                    "keterangan" => "Cash / Bank In (Trading)",
                    "is_aktif" => true,
                ],
                [
                    "nama_jenis" => "Cash / Bank In (Non-Trading)",
                    "keterangan" => "Cash / Bank In (Non-Trading)",
                    "is_aktif" => true,
                ],
                [
                    "nama_jenis" => "Cash / Bank Out (Settlement)",
                    "keterangan" => "Cash / Bank Out (Settlement)",
                    "is_aktif" => true,
                ],
                [
                    "nama_jenis" => "Cash / Bank Out (Pembayaran Fee)",
                    "keterangan" => "Cash / Bank Out (Pembayaran Fee)",
                    "is_aktif" => true,
                ],
                [
                    "nama_jenis" => "Cash / Bank Out (Pengembalian Collateral)",
                    "keterangan" => "Cash / Bank Out (Pengembalian Collateral)",
                    "is_aktif" => true,
                ],
            ];

            foreach ($temp as $t) {
                $status = new JenisTransaksi();
                $status->nama_jenis = $t['nama_jenis'];
                $status->keterangan = $t['keterangan'];
                $status->is_aktif = $t['is_aktif'];
                $status->save();
            }
        }
    }
}
