<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(StatusMemberSeed::class);
        $this->call(RoleSeed::class);
        $this->call(JenisInisiasiSeed::class);
        $this->call(JenisKomoditasSeed::class);
        $this->call(JenisDokumenSeed::class);
        $this->call(SuspendTypeSeed::class);
        $this->call(JenisPerdaganganSeed::class);
        $this->call(MutuSeed::class);
        $this->call(StatusPenyelesaianSeed::class);
        $this->call(JenisOpsiPembayaranLelangSeed::class);
        $this->call(JenisTransaksiSeed::class);
        $this->call(BankSeed::class);
        $this->call(MasterSesiLelangSeed::class);
        $this->call(JenisHargaSeed::class);
        $this->call(JenisSuratBerhargaSeed::class);
        $this->call(JenisPengeluaranJaminanSeed::class);
        $this->call(AreaSeed::class);
        $this->call(UserSeed::class);
        $this->call(MemberSeeder::class);
        $this->call(JenisVerifikasiSeeder::class);
        $this->call(StatusKontrakSeeder::class);
        $this->call(StatusLelangSeeder::class);
        $this->call(StatusEventLelangSeeder::class);
        $this->call(KomoditasSeeder::class);
        $this->call(JenisRegistrasiKomoditasSeeder::class);
        $this->call(StatusRegistrasiKomoditasSeeder::class);
        $this->call(JenisDokumenProdukSeeder::class);
    }
}
