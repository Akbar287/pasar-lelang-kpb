<?php

namespace Database\Seeders;

use App\Models\JenisRegistrasiKomoditas;
use Illuminate\Database\Seeder;

class JenisRegistrasiKomoditasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = JenisRegistrasiKomoditas::count();

        if ($cek == 0) {
            $temp = [
                [
                    'nama_jenis' => 'Registrasi Komoditas (IN)'
                ],
                [
                    'nama_jenis' => 'Registrasi Komoditas (OUT)'
                ],
            ];

            foreach ($temp as $t) {
                $j = new JenisRegistrasiKomoditas();
                $j->nama_jenis = $t['nama_jenis'];
                $j->save();
            }
        }
    }
}
