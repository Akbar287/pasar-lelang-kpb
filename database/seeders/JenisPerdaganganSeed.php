<?php

namespace Database\Seeders;

use App\Models\JenisPerdagangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisPerdaganganSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = JenisPerdagangan::count();
        if ($cek == 0) {
            $temp = [
                [
                    "nama_perdagangan" => "SPOT",
                    "keterangan" => "untuk membeli dengan opsi jangka waktu 0 - 3 bulan",
                    "is_aktif" => true
                ],
                [
                    "nama_perdagangan" => "FORWARD",
                    "keterangan" => "untuk membeli dengan opsi jangka waktu diatas 3 bulan",
                    "is_aktif" => true
                ],
            ];
            foreach ($temp as $t) {
                $status = new JenisPerdagangan();
                $status->nama_perdagangan = $t['nama_perdagangan'];
                $status->keterangan = $t['keterangan'];
                $status->is_aktif = $t['is_aktif'];
                $status->save();
            }
        }
    }
}
