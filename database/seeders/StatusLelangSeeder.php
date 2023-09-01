<?php

namespace Database\Seeders;

use App\Models\StatusLelang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusLelangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = StatusLelang::count();

        if ($cek == 0) {
            $temp = [
                ['nama_status' => 'Draft'],
                ['nama_status' => 'Daftar'],
                ['nama_status' => 'Verifikasi'],
                ['nama_status' => 'Aktif'],
                ['nama_status' => 'Tolak'],
                ['nama_status' => 'Suspend'],
                ['nama_status' => 'Selesai'],
            ];

            foreach ($temp as $t) {
                $status = new StatusLelang();
                $status->nama_status = $t['nama_status'];
                $status->save();
            }
        }
    }
}
