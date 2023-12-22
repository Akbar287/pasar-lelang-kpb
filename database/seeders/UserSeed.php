<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Bank;
use App\Models\Desa;
use App\Models\InformasiAkun;
use App\Models\InformasiKeuangan;
use App\Models\JenisInisiasi;
use App\Models\Npwp;
use App\Models\PenyelenggaraPasarLelang;
use App\Models\RekeningBank;
use App\Models\Role;
use App\Models\SettingCollateral;
use App\Models\StatusMember;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = User::count();
        $faker = Faker::create('id_ID');
        $banks = Bank::first();
        $inisiasi = JenisInisiasi::get();

        if ($cek == 0) {
            $statusMember = StatusMember::where('nama_status', 'Aktif')->first();
            $desa = Desa::where('nama_desa', 'Bumi Raya')->first();
            $roleAdmin = Role::where('nama_role', 'ROLE_ADMIN')->first();
            $area_member = $desa->area_member()->create([
                "kode_pos" => "12345",
                "alamat" => "Jalan Proklamasi No. 1",
                "alamat_ke" => "1",
            ]);

            $member = [
                "status_member_id" => $statusMember->status_member_id,
            ];

            $informasi = new InformasiAkun();
            $informasi->email = "muhammad_akbar@email.com";
            $informasi->no_hp = "081234567890";
            $informasi->no_wa = "081234567890";
            $informasi->no_fax = "081234567890";
            $informasi->avatar = "default.png";
            $informasi->save();

            $informasi->jaminan()->create([
                'total_saldo_jaminan' => 0,
                'saldo_teralokasi' => 0,
                'saldo_tersedia' => 0
            ]);

            $member = $informasi->member()->create($member);


            DB::table('area_member_informasi_akun')->insert([
                'area_member_id' => $area_member->area_member_id,
                'informasi_akun_id' => $informasi->informasi_akun_id
            ]);

            $userlogin = $informasi->userlogin()->create([
                "username" => "Akbar287",
                "password" => Hash::make("Akbar287"),
                "is_aktif" => true,
                "access_token" => null,
                "access" => null,
                "last_login" => null
            ]);

            $ktp = $member->ktp()->create([
                "nik" => "1029384756748392",
                "nama" => "Akbar",
                "jenis_kelamin" => "pria",
                "tempat_lahir" => "Jakarta",
                "tanggal_lahir" => "2000-02-10",
                "verified" => true,
            ]);

            $npwp = new Npwp();
            $npwp->npwp = '83249312478329';
            $npwp->save();

            $informasiKeuangan = new InformasiKeuangan();
            $informasiKeuangan->member_id = $member->member_id;
            $informasiKeuangan->npwp_id = $npwp->npwp_id;
            $informasiKeuangan->pekerjaan = 'Wiraswasta';
            $informasiKeuangan->pendapatan_tahunan = '1.000.001-10.000.000';
            $informasiKeuangan->kekayaan_bersih = $faker->randomNumber(9, true);
            $informasiKeuangan->kekayaan_lancar = $faker->randomNumber(9, true);
            $informasiKeuangan->sumber_dana = 'Milik Sendiri';
            $informasiKeuangan->keterangan = '';
            $informasiKeuangan->save();

            $rekening = new RekeningBank();
            $rekening->informasi_akun_id = $informasi->informasi_akun_id;
            $rekening->bank_id = $banks->bank_id;
            $rekening->nomor_rekening = $faker->creditCardNumber();
            $rekening->nama_pemilik = $faker->firstName();
            $rekening->cabang = $faker->country();
            $rekening->mata_uang = 'IDR';
            $rekening->nilai_awal = 0;
            $rekening->saldo = 0;
            $rekening->save();

            $admin = new Admin();
            $admin->member_id = $member->member_id;
            $admin->is_aktif = true;
            $admin->save();

            foreach ($inisiasi as $ini) {
                $setting = new SettingCollateral();
                $setting->member_id = $member->member_id;
                $setting->jenis_inisiasi_id = $ini->jenis_inisiasi_id;
                $setting->is_aktif = true;
                $setting->save();
            }

            DB::table('role_member')->insert([
                "role_id" => $roleAdmin->role_id,
                "member_id" => $member->member_id,
            ]);


            $pps = new PenyelenggaraPasarLelang();
            $pps->admin_id = $admin->admin_id;
            $pps->save();

            $pps->master_sesi_lelang()->create([
                'sesi' => 'Satu',
                'jam_mulai' => '08:00',
                'jam_berakhir' => '12:00',
                'is_aktif' => true,
            ]);
            $pps->master_sesi_lelang()->create([
                'sesi' => 'Dua',
                'jam_mulai' => '12:00',
                'jam_berakhir' => '15:00',
                'is_aktif' => true,
            ]);
            $pps->master_sesi_lelang()->create([
                'sesi' => 'Tiga',
                'jam_mulai' => '16:00',
                'jam_berakhir' => '18:00',
                'is_aktif' => true,
            ]);
        }
    }
}
