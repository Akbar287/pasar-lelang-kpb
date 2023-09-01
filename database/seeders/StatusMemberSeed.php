<?php

namespace Database\Seeders;

use App\Models\StatusMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusMemberSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = StatusMember::count();

        if ($cek == 0) {
            $temp = [
                [
                    "nama_status" => 'Aktif',
                    "keterangan" => "Member Aktif"
                ],
                [
                    "nama_status" => 'Suspend',
                    "keterangan" => "Member Di Suspend"
                ],
                [
                    "nama_status" => 'Tidak Aktif',
                    "keterangan" => "Member Di Non-Aktifkan"
                ],
                [
                    "nama_status" => 'Calon Anggota',
                    "keterangan" => "Member Baru Daftar"
                ],
            ];

            foreach ($temp as $t) {
                $status = new StatusMember();
                $status->nama_status = $t['nama_status'];
                $status->keterangan = $t['keterangan'];
                $status->save();
            }
        }
    }
}
