<?php

namespace Database\Seeders;

use App\Models\JenisVerifikasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisVerifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenis = JenisVerifikasi::get();

        if (count($jenis) == 0) {
            $temp = [
                [
                    "nama_verifikasi" => "Verifikasi Calon Anggota",
                    "keterangan" => "Calon Anggota"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Approval Lelang",
                    "keterangan" => "Approval Lelang"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Suspend Anggota",
                    "keterangan" => "Suspend Anggota Lelang"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Re-Aktivasi Anggota",
                    "keterangan" => "Reaktivasi Anggota Lelang"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Produk Lelang",
                    "keterangan" => "Verifikasi Produk Lelang"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Suspend Produk Lelang",
                    "keterangan" => "Verifikasi Suspend Produk Lelang"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Re-Aktivasi Produk Lelang",
                    "keterangan" => "Verifikasi Re-Aktivasi Produk Lelang"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Keuangan",
                    "keterangan" => "Verifikasi Keuangan"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Gudang",
                    "keterangan" => "Verifikasi Gudang"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Jaminan Penerimaan",
                    "keterangan" => "Verifikasi Jaminan Penerimaan"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Jaminan Pengeluaran",
                    "keterangan" => "Verifikasi Jaminan Pengeluaran"
                ],
                [
                    "nama_verifikasi" => "Verifikasi Transaksi Lelang",
                    "keterangan" => "Verifikasi Transaksi Lelang"
                ],
            ];

            foreach ($temp as $t) {
                $jenis = new JenisVerifikasi();
                $jenis->nama_verifikasi = $t['nama_verifikasi'];
                $jenis->keterangan = $t['keterangan'];
                $jenis->save();
            }
        }
    }
}
