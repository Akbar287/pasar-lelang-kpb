<?php

namespace Database\Seeders;

use App\Models\SuspendType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuspendTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = SuspendType::count();

        if ($cek == 0) {
            $temp = [
                [
                    'nama_suspend' => 'SUSPEND',
                    'keterangan' => 'Member di suspend tanpa alasan'
                ],
                [
                    'nama_suspend' => 'PENGUNDURAN DIRI',
                    'keterangan' => 'Member di suspend dengan alasan mengundurkan diri'
                ],
                [
                    'nama_suspend' => 'PENCABUTAN',
                    'keterangan' => 'Member di suspend dengan alasan dicabut hak akses lelang'
                ],
            ];

            foreach ($temp as $t) {
                $status = new SuspendType();
                $status->nama_suspend = $t['nama_suspend'];
                $status->keterangan = $t['keterangan'];
                $status->save();
            }
        }
    }
}
