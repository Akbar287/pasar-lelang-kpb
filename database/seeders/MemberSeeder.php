<?php

namespace Database\Seeders;

use App\Models\AreaMember;
use App\Models\Bank;
use App\Models\Desa;
use App\Models\InformasiAkun;
use App\Models\InformasiKeuangan;
use App\Models\JenisInisiasi;
use App\Models\Ktp;
use App\Models\Lembaga;
use App\Models\Member;
use App\Models\Npwp;
use App\Models\RekeningBank;
use App\Models\SettingCollateral;
use App\Models\StatusMember;
use App\Models\Userlogin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $statusMember = StatusMember::where('nama_status', 'Calon Anggota')->first();
        $desa = Desa::get()->first();
        $banks = Bank::first();
        $inisiasi = JenisInisiasi::get();

        $cek = Member::count();
        if ($cek == 1) {
            for ($i = 1; $i <= 50; $i++) {
                $informasi = new InformasiAkun();
                $informasi->email = $faker->email();
                $informasi->no_hp = str_replace(' ', '', $faker->phoneNumber());
                $informasi->no_wa = str_replace(' ', '', $faker->phoneNumber());
                $informasi->no_fax = str_replace(' ', '', $faker->phoneNumber());
                $informasi->avatar = 'default.png';
                $informasi->save();

                $informasi->jaminan()->create([
                    'total_saldo_jaminan' => 0,
                    'saldo_teralokasi' => 0,
                    'saldo_tersedia' => 0
                ]);

                $areaMember = new AreaMember();
                $areaMember->desa_id = $desa->desa_id;
                $areaMember->kode_pos = $faker->postcode();
                $areaMember->alamat = $faker->address();
                $areaMember->alamat_ke = 1;
                $areaMember->save();

                DB::table('area_member_informasi_akun')->insert([
                    'area_member_id' => $areaMember->area_member_id,
                    'informasi_akun_id' => $informasi->informasi_akun_id
                ]);

                $npwp = new Npwp();
                $npwp->npwp = $faker->nik();
                $npwp->save();

                $member = new Member();
                $member->informasi_akun_id = $informasi->informasi_akun_id;
                $member->status_member_id = $statusMember->status_member_id;
                $member->save();

                $ktp = new Ktp();
                $ktp->member_id = $member->member_id;
                $ktp->nik = $faker->nik();
                $ktp->nama = $faker->firstName() . ' ' . $faker->lastName();
                $ktp->jenis_kelamin = rand(0, 1) == 1 ? 'pria' : 'wanita';
                $ktp->tempat_lahir = $faker->country();
                $ktp->tanggal_lahir = $faker->date('Y_m_d');
                $ktp->verified = false;
                $ktp->save();

                $userlogin = new Userlogin();
                $userlogin->informasi_akun_id = $informasi->informasi_akun_id;
                $userlogin->username = $faker->userName();
                $userlogin->password = Hash::make($faker->userName());
                $userlogin->is_aktif = true;
                $userlogin->save();

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

                foreach ($inisiasi as $ini) {
                    $setting = new SettingCollateral();
                    $setting->member_id = $member->member_id;
                    $setting->jenis_inisiasi_id = $ini->jenis_inisiasi_id;
                    $setting->is_aktif = true;
                    $setting->save();
                }
            }

            // Lembaga
            for ($i = 1; $i <= 50; $i++) {
                $informasi = new InformasiAkun();
                $informasi->email = $faker->email();
                $informasi->no_hp = $faker->phoneNumber();
                $informasi->no_wa = $faker->phoneNumber();
                $informasi->no_fax = $faker->phoneNumber();
                $informasi->avatar = 'default.png';
                $informasi->save();

                $informasi->jaminan()->create([
                    'total_saldo_jaminan' => 0,
                    'saldo_teralokasi' => 0,
                    'saldo_tersedia' => 0
                ]);

                $npwp = new Npwp();
                $npwp->npwp = $faker->nik();
                $npwp->save();

                $areaMember = new AreaMember();
                $areaMember->desa_id = $desa->desa_id;
                $areaMember->kode_pos = $faker->postcode();
                $areaMember->alamat = $faker->address();
                $areaMember->alamat_ke = 1;
                $areaMember->save();


                DB::table('area_member_informasi_akun')->insert([
                    'area_member_id' => $areaMember->area_member_id,
                    'informasi_akun_id' => $informasi->informasi_akun_id
                ]);

                $lembaga = new Lembaga();
                $lembaga->informasi_akun_id = $informasi->informasi_akun_id;
                $lembaga->status_member_id = $statusMember->status_member_id;
                $lembaga->npwp_id = $npwp->npwp_id;
                $lembaga->nama_lembaga = $faker->company();
                $lembaga->bidang_usaha = 'Makanan';
                $lembaga->is_aktif = false;
                $lembaga->save();

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

                $userlogin = new Userlogin();
                $userlogin->informasi_akun_id = $informasi->informasi_akun_id;
                $userlogin->username = $faker->userName();
                $userlogin->password = Hash::make($faker->userName());
                $userlogin->is_aktif = true;
                $userlogin->save();


                foreach ($inisiasi as $ini) {
                    $setting = new SettingCollateral();
                    $setting->member_id = $member->member_id;
                    $setting->jenis_inisiasi_id = $ini->jenis_inisiasi_id;
                    $setting->is_aktif = true;
                    $setting->save();
                }
            }
        }
    }
}
