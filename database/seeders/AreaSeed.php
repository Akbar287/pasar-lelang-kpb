<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cekProvinsi = Provinsi::count();
        $cekKabupaten = Kabupaten::count();
        $cekKecamatan = Kecamatan::count();
        $cekDesa = Desa::count();

        if ($cekProvinsi == 0) {
            $provinsi = new Provinsi();
            $provinsi->nama_provinsi = "Lampung";
            $provinsi->save();

            if ($cekKabupaten == 0) {
                $kabupaten = $provinsi->kabupaten()->create([
                    "nama_kabupaten" => "Bandar Lampung"
                ]);

                if ($cekKecamatan == 0) {
                    $temp = [
                        ["nama_kecamatan" => "Bumi Waras"],
                        ["nama_kecamatan" => "Enggal"],
                        ["nama_kecamatan" => "Kedamaian"],
                        ["nama_kecamatan" => "Kedaton"],
                        ["nama_kecamatan" => "Kemiling"],
                        ["nama_kecamatan" => "Labuhan Ratu"],
                        ["nama_kecamatan" => "Langkapura"],
                        ["nama_kecamatan" => "PanjangRajabasa"],
                        ["nama_kecamatan" => "Sukabumi"],
                        ["nama_kecamatan" => "Sukarame"],
                        ["nama_kecamatan" => "Tanjung Senang"],
                        ["nama_kecamatan" => "Tanjung Karang Barat"],
                        ["nama_kecamatan" => "Tanjung Karang Pusat"],
                        ["nama_kecamatan" => "Tanjung Karang Timur"],
                        ["nama_kecamatan" => "Teluk Betung Barat"],
                        ["nama_kecamatan" => "Teluk Betung Selatan"],
                        ["nama_kecamatan" => "Teluk Betung Timur"],
                        ["nama_kecamatan" => "Teluk Betung Utara"],
                        ["nama_kecamatan" => "Way Halim"],
                    ];
                    foreach ($temp as $t) {
                        $kabupaten->kecamatan()->create($t);
                    }

                    if ($cekDesa == 0) {
                        $desa1 = [
                            ["nama_desa" => "Bumi Raya"],
                            ["nama_desa" => "Bumi Waras"],
                            ["nama_desa" => "Garuntang"],
                            ["nama_desa" => "Kangkung"],
                            ["nama_desa" => "Sukaraja"],
                        ];
                        foreach ($desa1 as $d) {
                            Kecamatan::where("nama_kecamatan", 'Bumi Waras')->first()->desa()->create($d);
                        }
                    }
                }
            }
        }
    }
}
