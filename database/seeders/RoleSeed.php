<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = Role::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_role" => "ROLE_PEMBELI",
                    "keterangan" => "Role untuk membeli lelang produk",
                    "is_aktif" => true
                ],
                [
                    "nama_role" => "ROLE_PEMBELI",
                    "keterangan" => "Role untuk membeli lelang produk",
                    "is_aktif" => true
                ],
                [
                    "nama_role" => "ROLE_DINAS",
                    "keterangan" => "Role untuk melihat laporan informasi semua lelang",
                    "is_aktif" => true
                ],
                [
                    "nama_role" => "ROLE_ADMIN",
                    "keterangan" => "Role untuk mengatur data master lelang",
                    "is_aktif" => true
                ],
                [
                    "nama_role" => "ROLE_PENYELENGGARA",
                    "keterangan" => "Role untuk mengatur jalannnya sesi lelang",
                    "is_aktif" => true
                ],
            ];

            foreach ($temp as $t) {
                $status = new Role();
                $status->nama_role = $t['nama_role'];
                $status->keterangan = $t['keterangan'];
                $status->is_aktif = $t['is_aktif'];
                $status->save();
            }
        }
    }
}
