<?php

namespace Database\Seeders;

use App\Models\JenisKomoditas;
use App\Models\Komoditas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KomoditasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = Komoditas::count();

        if ($cek == 0) {
            $temp = [
                [
                    'nama_komoditas' => "beras",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "jagung",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "kedelai",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "singkong",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "ubi",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "cabai rawit",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "bawang merah",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "bawang putih",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "daun bawang",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "kol",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "kentang",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "pisang",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "buah durian",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "mangga",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "jeruk",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "kunyit",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "jahe",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "temulawak",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "tebu",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "biji kopi",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "daun teh",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "daun tembakau",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "biji kakao",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "kulit kayu kinin",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "kulit kayu manis",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "kacang mete",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "cengkeh",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "pala",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "lada",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
                [
                    'nama_komoditas' => "serai",
                    'satuan_ukuran' => 'Kg',
                    'inisiasi' => true,
                    'kadaluarsa' => false
                ],
            ];

            $jenisKomoditas = JenisKomoditas::where('nama_jenis_komoditas', 'Non-Resi Gudang')->first();
            foreach ($temp as $t) {
                $jenisKomoditas->komoditas()->create([
                    'nama_komoditas' => $t['nama_komoditas'],
                    'satuan_ukuran' => $t['satuan_ukuran'],
                    'inisiasi' => $t['inisiasi'],
                    'kadaluarsa' => $t['kadaluarsa'],
                ]);
            }
        }
    }
}
