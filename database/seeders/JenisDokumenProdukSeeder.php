<?php

namespace Database\Seeders;

use App\Models\JenisDokumenProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisDokumenProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisDokumenProduk = JenisDokumenProduk::count();

        if ($jenisDokumenProduk == 0) {
            $temp = ['Sertifikat', 'Gambar', 'Video', 'Dokumen', 'File Lainnya'];

            foreach ($temp as $t) {
                JenisDokumenProduk::create([
                    'nama_jenis' => $t
                ]);
            }
        }
    }
}
