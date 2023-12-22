<?php

namespace Database\Seeders;

use App\Models\StatusRegistrasiKomoditas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusRegistrasiKomoditasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = StatusRegistrasiKomoditas::count();

        if ($cek == 0) {
            $temp = [
                [
                    'nama_status' => 'Baru'
                ],
                [
                    'nama_status' => 'Verifikasi'
                ],
                [
                    'nama_status' => 'Selesai'
                ],
                [
                    'nama_status' => 'Suspend'
                ],
                [
                    'nama_status' => 'Tolak'
                ],
            ];

            foreach ($temp as $t) {
                $s = new StatusRegistrasiKomoditas();
                $s->nama_status = $t['nama_status'];
                $s->save();
            }
        }
    }
}
