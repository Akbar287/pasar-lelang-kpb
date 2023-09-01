<?php

namespace Database\Seeders;

use App\Models\Mutu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MutuSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = Mutu::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_mutu" => "SNI Mutu #1",
                    "keterangan" => "SNI Mutu #1",
                    "is_aktif" => true
                ],
                [
                    "nama_mutu" => "SNI Mutu #2",
                    "keterangan" => "SNI Mutu #2",
                    "is_aktif" => true
                ],
                [
                    "nama_mutu" => "SNI Mutu #3",
                    "keterangan" => "SNI Mutu #3",
                    "is_aktif" => true
                ],
            ];
            foreach ($temp as $t) {
                $status = new Mutu();
                $status->nama_mutu = $t['nama_mutu'];
                $status->keterangan = $t['keterangan'];
                $status->is_aktif = $t['is_aktif'];
                $status->save();
            }
        }
    }
}
