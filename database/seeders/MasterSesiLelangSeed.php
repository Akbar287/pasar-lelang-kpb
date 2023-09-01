<?php

namespace Database\Seeders;

use App\Models\MasterSesiLelang;
use App\Models\PenyelenggaraPasarLelang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterSesiLelangSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = MasterSesiLelang::count();
        $admin = PenyelenggaraPasarLelang::count();

        if ($cek == 0 && $admin > 0) {
            $temp = [
                [
                    "sesi" => "1",
                    "jam_mulai" => "09:00",
                    "jam_berakhir" => "11:00",
                    "is_aktif" => true,
                ],
                [
                    "sesi" => "2",
                    "jam_mulai" => "13:00",
                    "jam_berakhir" => "15:00",
                    "is_aktif" => true,
                ],
                [
                    "sesi" => "3",
                    "jam_mulai" => "16:00",
                    "jam_berakhir" => "18:00",
                    "is_aktif" => true,
                ],
            ];

            $penyelenggara = PenyelenggaraPasarLelang::first();
            $penyelenggara->master_sesi_lelang()->insert($temp);
        }
    }
}
