<?php

namespace Database\Seeders;

use App\Models\StatusKontrak;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusKontrakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = StatusKontrak::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_status" => "Pendaftar Baru",
                    "keterangan" => "Kontrak Pendaftar Baru"
                ],
                [
                    "nama_status" => "Aktif",
                    "keterangan" => "Kontrak Aktif"
                ],
                [
                    "nama_status" => "Non-Aktif",
                    "keterangan" => "Kontrak Non-Aktif"
                ]
            ];

            foreach ($temp as $t) {
                $status = new StatusKontrak();
                $status->nama_status = $t['nama_status'];
                $status->keterangan = $t['keterangan'];
                $status->save();
            }
        }
    }
}
