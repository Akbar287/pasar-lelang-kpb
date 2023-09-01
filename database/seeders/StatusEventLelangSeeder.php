<?php

namespace Database\Seeders;

use App\Models\StatusEventLelang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusEventLelangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = StatusEventLelang::count();

        if ($cek == 0) {
            $temp = [
                [
                    'nama_status' => 'Lelang Baru',
                    'is_aktif' => true,
                    'urutan' => 1,
                    'icon' => 'fas fa-calendar',
                    'keterangan' => 'Lelang Baru'
                ],
                [
                    'nama_status' => 'Sinkronisasi Inisiasi Jual',
                    'is_aktif' => true,
                    'urutan' => 2,
                    'icon' => 'fas fa-shopping-bag',
                    'keterangan' => 'Sinkronisasi Inisiasi Jual'
                ],
                [
                    'nama_status' => 'Sinkronisasi Anggota Lelang',
                    'is_aktif' => true,
                    'urutan' => 3,
                    'icon' => 'fas fa-user',
                    'keterangan' => 'Sinkronisasi Anggota Lelang'
                ],
                [
                    'nama_status' => 'Lelang Berlangsung',
                    'is_aktif' => true,
                    'urutan' => 4,
                    'icon' => 'fas fa-clock',
                    'keterangan' => 'Lelang Berlangsung'
                ],
                [
                    'nama_status' => 'Selesai',
                    'is_aktif' => true,
                    'urutan' => 5,
                    'icon' => 'fas fa-check',
                    'keterangan' => 'Selesai'
                ],
            ];

            foreach ($temp as $t) {
                $status = new StatusEventLelang();
                $status->nama_status = $t['nama_status'];
                $status->is_aktif = $t['is_aktif'];
                $status->keterangan = $t['keterangan'];
                $status->icon = $t['icon'];
                $status->urutan = $t['urutan'];
                $status->save();
            }
        }
    }
}
