<?php

use App\Http\Controllers\Administrasi\AdministrasiPasarLelangController;
use App\Http\Controllers\Administrasi\Gudang\GudangController;
use App\Http\Controllers\Administrasi\Gudang\ListGudangController;
use App\Http\Controllers\Administrasi\Gudang\PenerimaanGudangController;
use App\Http\Controllers\Administrasi\Gudang\VerifikasiGudangController;
use App\Http\Controllers\Administrasi\JaminanLelang\JaminanLelangController;
use App\Http\Controllers\Administrasi\KasBank\KasBankController;
use App\Http\Controllers\Administrasi\KasBank\ListKasBankController;
use App\Http\Controllers\Administrasi\KasBank\PenerimaanKasBankController;
use App\Http\Controllers\Administrasi\KasBank\VerifikasiKasBankController;
use App\Http\Controllers\LelangOnline\AnggotaEventLelangOnlineController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Konfigurasi\KonfigurasiController;
use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\Laporan\LaporanJaminan\LaporanJaminanController;
use App\Http\Controllers\Laporan\LaporanTransaksiBank\LaporanTransaksiBankController;
use App\Http\Controllers\Laporan\LaporanTransaksiLelang\LaporanTransaksiLelangController;
use App\Http\Controllers\LelangOffline\EventLelangAnggotaController;
use App\Http\Controllers\LelangOffline\EventLelangController;
use App\Http\Controllers\LelangOffline\EventLelangProdukController;
use App\Http\Controllers\LelangOffline\LelangOfflineController;
use App\Http\Controllers\LelangOffline\OfflineProfileController;
use App\Http\Controllers\LelangOffline\OperatorPasarLelangController;
use App\Http\Controllers\LelangOnline\EventLelangOnlineController;
use App\Http\Controllers\LelangOnline\LelangOnlineController;
use App\Http\Controllers\MasterData\Anggota\AnggotaDibekukanController;
use App\Http\Controllers\MasterData\Anggota\AnggotaPasarLelangController;
use App\Http\Controllers\MasterData\Anggota\AreaMemberController;
use App\Http\Controllers\MasterData\Anggota\CalonAnggotaController;
use App\Http\Controllers\MasterData\Anggota\DaftarAnggotaController;
use App\Http\Controllers\MasterData\Anggota\DokumenMemberController;
use App\Http\Controllers\MasterData\Anggota\RekeningBankController;
use App\Http\Controllers\MasterData\Anggota\VerifikasiCalonAnggotaController;
use App\Http\Controllers\MasterData\Anggota\VerifikasiPerubahanDataController;
use App\Http\Controllers\MasterData\Kontrak\KontrakPasarLelangController;
use App\Http\Controllers\MasterData\Kontrak\ListKontrakController;
use App\Http\Controllers\MasterData\Kontrak\ListKontrakTidakAktifController;
use App\Http\Controllers\MasterData\Kontrak\PengaturanKontrakController;
use App\Http\Controllers\MasterData\Kontrak\VerifikasiKontrakController;
use App\Http\Controllers\MasterData\Lainnya\DokumenPersyaratanController;
use App\Http\Controllers\MasterData\Lainnya\KomoditasController;
use App\Http\Controllers\MasterData\Lainnya\MasterLainnyaController;
use App\Http\Controllers\MasterData\Lainnya\PengaturanHariLiburController;
use App\Http\Controllers\MasterData\Lainnya\RekeningBankAdminController;
use App\Http\Controllers\MasterData\Lembaga\LembagaPendukungController;
use App\Http\Controllers\MasterData\MasterDataController;
use App\Http\Controllers\MasterData\Lainnya\MasterSesiPerdaganganController;
use App\Http\Controllers\MasterData\Lembaga\BankController;
use App\Http\Controllers\MasterData\Lembaga\MasterDataGudangController;
use App\Http\Controllers\Operational\OperationalPasarLelangController;
use App\Http\Controllers\Transaksi\DaftarLelangController;
use App\Http\Controllers\Transaksi\DokumenProdukLelangController;
use App\Http\Controllers\Transaksi\DokumenProdukLelangListController;
use App\Http\Controllers\Transaksi\LelangBaruController;
use App\Http\Controllers\Transaksi\TransaksiPasarLelangController;
use App\Http\Controllers\Transaksi\VerifikasiLelangController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false
]);

Route::middleware('auth')->group(function ($route) {
    $route->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    $route->get('/home/provinsi', [HomeController::class, 'provinsi'])->name('area.provinsi');
    $route->get('/home/kabupaten/{provinsi}', [HomeController::class, 'kabupaten'])->name('area.kabupaten');
    $route->get('/home/kecamatan/{kabupaten}', [HomeController::class, 'kecamatan'])->name('area.kecamatan');
    $route->get('/home/desa/{kecamatan}', [HomeController::class, 'desa'])->name('area.desa');

    // Menu Master Data
    $route->get('/master', MasterDataController::class)->name('master');

    /// Menu Master Data -> Anggota
    $route->get('/master/anggota', AnggotaPasarLelangController::class)->name('master.anggota');

    //// Menu Master Data -> Anggota -> Calon Anggota
    $route->get('/master/anggota/calon', [CalonAnggotaController::class, 'index'])->name('master.anggota.calon');
    $route->get('/master/anggota/calon/create', [CalonAnggotaController::class, 'create'])->name('master.anggota.calon.create');
    $route->post('/master/anggota/calon', [CalonAnggotaController::class, 'store'])->name('master.anggota.calon.store');
    $route->get('/master/anggota/calon/{calon}', [CalonAnggotaController::class, 'show'])->name('master.anggota.calon.show');
    $route->get('/master/anggota/calon/{calon}/edit', [CalonAnggotaController::class, 'edit'])->name('master.anggota.calon.edit');
    $route->put('/master/anggota/calon/{calon}', [CalonAnggotaController::class, 'update'])->name('master.anggota.calon.update');
    $route->delete('/master/anggota/calon/{calon}', [CalonAnggotaController::class, 'destroy'])->name('master.anggota.calon.destroy');

    //// Menu Master Data -> Anggota -> Verifikasi Calon Anggota
    $route->get('/master/anggota/verifikasi', [VerifikasiCalonAnggotaController::class, 'index'])->name('master.anggota.verifikasi');
    $route->post('/master/anggota/verifikasi/{calon}', [VerifikasiCalonAnggotaController::class, 'store'])->name('master.anggota.verifikasi.store');
    $route->get('/master/anggota/verifikasi/{calon}', [VerifikasiCalonAnggotaController::class, 'show'])->name('master.anggota.verifikasi.show');

    //// Menu Master Data -> Anggota -> Daftar Anggota
    $route->get('/master/anggota/list', [DaftarAnggotaController::class, 'index'])->name('master.anggota.list');
    $route->get('/master/anggota/list/create', [DaftarAnggotaController::class, 'create'])->name('master.anggota.list.create');
    $route->get('/master/anggota/list/{anggota}/suspend', [DaftarAnggotaController::class, 'suspend_index'])->name('master.anggota.list.suspend.index');
    $route->post('/master/anggota/list/{anggota}/suspend', [DaftarAnggotaController::class, 'suspend'])->name('master.anggota.list.suspend');
    $route->get('/master/anggota/list/{anggota}', [DaftarAnggotaController::class, 'show'])->name('master.anggota.list.show');

    $route->get('/master/anggota/list/{anggota}/rekening', [RekeningBankController::class, 'index'])->name('master.anggota.list.rekening.index');
    $route->get('/master/anggota/list/{anggota}/rekening/create', [RekeningBankController::class, 'create'])->name('master.anggota.list.rekening.create');
    $route->post('/master/anggota/list/{anggota}/rekening', [RekeningBankController::class, 'store'])->name('master.anggota.list.rekening.store');
    $route->get('/master/anggota/list/{anggota}/rekening/{rekening}', [RekeningBankController::class, 'show'])->name('master.anggota.list.rekening.show');
    $route->get('/master/anggota/list/{anggota}/rekening/{rekening}/edit', [RekeningBankController::class, 'edit'])->name('master.anggota.list.rekening.edit');
    $route->put('/master/anggota/list/{anggota}/rekening/{rekening}', [RekeningBankController::class, 'update'])->name('master.anggota.list.rekening.update');
    $route->delete('/master/anggota/list/{anggota}/rekening/{rekening}', [RekeningBankController::class, 'destroy'])->name('master.anggota.list.rekening.destroy');

    $route->get('/master/anggota/list/{anggota}/area', [AreaMemberController::class, 'index'])->name('master.anggota.list.area.index');
    $route->get('/master/anggota/list/{anggota}/area/create', [AreaMemberController::class, 'create'])->name('master.anggota.list.area.create');
    $route->post('/master/anggota/list/{anggota}/area', [AreaMemberController::class, 'store'])->name('master.anggota.list.area.store');
    $route->get('/master/anggota/list/{anggota}/area/{area}', [AreaMemberController::class, 'show'])->name('master.anggota.list.area.show');
    $route->get('/master/anggota/list/{anggota}/area/{area}/edit', [AreaMemberController::class, 'edit'])->name('master.anggota.list.area.edit');
    $route->put('/master/anggota/list/{anggota}/area/{area}', [AreaMemberController::class, 'update'])->name('master.anggota.list.area.update');
    $route->delete('/master/anggota/list/{anggota}/area/{area}', [AreaMemberController::class, 'destroy'])->name('master.anggota.list.area.destroy');

    $route->get('/master/anggota/list/{anggota}/dokumen', [DokumenMemberController::class, 'index'])->name('master.anggota.list.dokumen.index');
    $route->get('/master/anggota/list/{anggota}/dokumen/create', [DokumenMemberController::class, 'create'])->name('master.anggota.list.dokumen.create');
    $route->post('/master/anggota/list/{anggota}/dokumen', [DokumenMemberController::class, 'store'])->name('master.anggota.list.dokumen.store');
    $route->get('/master/anggota/list/{anggota}/dokumen/{dokumen}', [DokumenMemberController::class, 'show'])->name('master.anggota.list.dokumen.show');
    $route->get('/master/anggota/list/{anggota}/dokumen/{dokumen}/edit', [DokumenMemberController::class, 'edit'])->name('master.anggota.list.dokumen.edit');
    $route->put('/master/anggota/list/{anggota}/dokumen/{dokumen}', [DokumenMemberController::class, 'update'])->name('master.anggota.list.dokumen.update');
    $route->delete('/master/anggota/list/{anggota}/dokumen/{dokumen}', [DokumenMemberController::class, 'destroy'])->name('master.anggota.list.dokumen.destroy');

    $route->get('/master/anggota/list/{anggota}/edit', [DaftarAnggotaController::class, 'edit'])->name('master.anggota.list.edit');
    $route->put('/master/anggota/list/{anggota}', [DaftarAnggotaController::class, 'update'])->name('master.anggota.list.update');
    $route->delete('/master/anggota/list/{anggota}', [DaftarAnggotaController::class, 'destroy'])->name('master.anggota.list.destroy');

    //// Menu Master Data -> Anggota -> Verifikasi Perubahan Data Anggota
    $route->get('/master/anggota/perubahan', [VerifikasiPerubahanDataController::class, 'index'])->name('master.anggota.perubahan');
    $route->get('/master/anggota/perubahan/create', [VerifikasiPerubahanDataController::class, 'create'])->name('master.anggota.perubahan.create');
    $route->post('/master/anggota/perubahan', [VerifikasiPerubahanDataController::class, 'store'])->name('master.anggota.perubahan.store');
    $route->get('/master/anggota/perubahan/{verifikasi}', [VerifikasiPerubahanDataController::class, 'show'])->name('master.anggota.perubahan.show');
    $route->get('/master/anggota/perubahan/{verifikasi}/edit', [VerifikasiPerubahanDataController::class, 'edit'])->name('master.anggota.perubahan.edit');
    $route->put('/master/anggota/perubahan/{verifikasi}', [VerifikasiPerubahanDataController::class, 'update'])->name('master.anggota.perubahan.update');
    $route->delete('/master/anggota/perubahan/{verifikasi}', [VerifikasiPerubahanDataController::class, 'destroy'])->name('master.anggota.perubahan.destroy');

    //// Menu Master Data -> Anggota -> Anggota Dibekukan
    $route->get('/master/anggota/dibekukan', [AnggotaDibekukanController::class, 'index'])->name('master.anggota.dibekukan');
    $route->post('/master/anggota/dibekukan/{anggota}/{suspend}', [AnggotaDibekukanController::class, 'store'])->name('master.anggota.dibekukan.store');
    $route->get('/master/anggota/dibekukan/{anggota}/{suspend}', [AnggotaDibekukanController::class, 'show'])->name('master.anggota.dibekukan.show');


    /// Menu Master Data -> Kontrak
    $route->get('/master/kontrak', KontrakPasarLelangController::class)->name('master.kontrak');

    $route->get('/master/kontrak/pengaturan', [PengaturanKontrakController::class, 'index'])->name('master.kontrak.pengaturan');
    $route->get('/master/kontrak/pengaturan/create', [PengaturanKontrakController::class, 'create'])->name('master.kontrak.pengaturan.create');
    $route->post('/master/kontrak/pengaturan', [PengaturanKontrakController::class, 'store'])->name('master.kontrak.pengaturan.store');
    $route->get('/master/kontrak/pengaturan/{kontrak}', [PengaturanKontrakController::class, 'show'])->name('master.kontrak.pengaturan.show');
    $route->get('/master/kontrak/pengaturan/{kontrak}/edit', [PengaturanKontrakController::class, 'edit'])->name('master.kontrak.pengaturan.edit');
    $route->put('/master/kontrak/pengaturan/{kontrak}', [PengaturanKontrakController::class, 'update'])->name('master.kontrak.pengaturan.update');
    $route->delete('/master/kontrak/pengaturan/{kontrak}', [PengaturanKontrakController::class, 'destroy'])->name('master.kontrak.pengaturan.destroy');

    $route->get('/master/kontrak/verifikasi/riwayat', [VerifikasiKontrakController::class, 'index_riwayat'])->name('master.kontrak.verifikasi.riwayat');
    $route->get('/master/kontrak/verifikasi/riwayat/{kontrak}', [VerifikasiKontrakController::class, 'show_riwayat'])->name('master.kontrak.verifikasi.riwayat.show');
    $route->get('/master/kontrak/verifikasi', [VerifikasiKontrakController::class, 'index'])->name('master.kontrak.verifikasi');
    $route->post('/master/kontrak/verifikasi/{kontrak}', [VerifikasiKontrakController::class, 'store'])->name('master.kontrak.verifikasi.store');
    $route->get('/master/kontrak/verifikasi/{kontrak}', [VerifikasiKontrakController::class, 'show'])->name('master.kontrak.verifikasi.show');

    $route->get('/master/kontrak/list', [ListKontrakController::class, 'index'])->name('master.kontrak.list');
    $route->get('/master/kontrak/list/{kontrak}', [ListKontrakController::class, 'show'])->name('master.kontrak.list.show');
    $route->get('/master/kontrak/list/{kontrak}/edit', [ListKontrakController::class, 'edit'])->name('master.kontrak.list.edit');
    $route->put('/master/kontrak/list/{kontrak}', [ListKontrakController::class, 'update'])->name('master.kontrak.list.update');
    $route->delete('/master/kontrak/list/{kontrak}', [ListKontrakController::class, 'destroy'])->name('master.kontrak.list.destroy');

    $route->get('/master/kontrak/non-aktif', [ListKontrakTidakAktifController::class, 'index'])->name('master.kontrak.nonaktif');
    $route->get('/master/kontrak/non-aktif/{kontrak}', [ListKontrakTidakAktifController::class, 'show'])->name('master.kontrak.nonaktif.show');
    $route->put('/master/kontrak/non-aktif/{kontrak}', [ListKontrakTidakAktifController::class, 'aktif'])->name('master.kontrak.nonaktif.aktif');

    /// Menu Master Data -> Lembaga
    $route->get('/master/lembaga', LembagaPendukungController::class)->name('master.lembaga');

    //// Menu Master Data -> Lembaga -> Bank
    $route->get('/master/lembaga/bank', [BankController::class, 'index'])->name('master.lembaga.bank');
    $route->get('/master/lembaga/bank/create', [BankController::class, 'create'])->name('master.lembaga.bank.create');
    $route->post('/master/lembaga/bank', [BankController::class, 'store'])->name('master.lembaga.bank.store');
    $route->get('/master/lembaga/bank/{bank}', [BankController::class, 'show'])->name('master.lembaga.bank.show');
    $route->get('/master/lembaga/bank/{bank}/edit', [BankController::class, 'edit'])->name('master.lembaga.bank.edit');
    $route->put('/master/lembaga/bank/{bank}', [BankController::class, 'update'])->name('master.lembaga.bank.update');
    $route->delete('/master/lembaga/bank/{bank}', [BankController::class, 'destroy'])->name('master.lembaga.bank.destroy');

    //// Menu Master Data -> Lembaga -> Gudang
    $route->get('/master/lembaga/gudang', [MasterDataGudangController::class, 'index'])->name('master.lembaga.gudang');
    $route->get('/master/lembaga/gudang/create', [MasterDataGudangController::class, 'create'])->name('master.lembaga.gudang.create');
    $route->post('/master/lembaga/gudang', [MasterDataGudangController::class, 'store'])->name('master.lembaga.gudang.store');
    $route->get('/master/lembaga/gudang/{gudang}', [MasterDataGudangController::class, 'show'])->name('master.lembaga.gudang.show');
    $route->get('/master/lembaga/gudang/{gudang}/edit', [MasterDataGudangController::class, 'edit'])->name('master.lembaga.gudang.edit');
    $route->put('/master/lembaga/gudang/{gudang}', [MasterDataGudangController::class, 'update'])->name('master.lembaga.gudang.update');
    $route->delete('/master/lembaga/gudang/{gudang}', [MasterDataGudangController::class, 'destroy'])->name('master.lembaga.gudang.destroy');

    /// Menu Master Data -> Lain
    $route->get('/master/lain', MasterLainnyaController::class)->name('master.lain');

    //// Menu Master Data -> Lain -> Master Sesi Perdagangan
    $route->get('/master/lain/sesi', [MasterSesiPerdaganganController::class, 'index'])->name('master.lain.sesi');
    $route->get('/master/lain/sesi/create', [MasterSesiPerdaganganController::class, 'create'])->name('master.lain.sesi.create');
    $route->post('/master/lain/sesi', [MasterSesiPerdaganganController::class, 'store'])->name('master.lain.sesi.store');
    $route->get('/master/lain/sesi/{sesi}', [MasterSesiPerdaganganController::class, 'show'])->name('master.lain.sesi.show');
    $route->get('/master/lain/sesi/{sesi}/edit', [MasterSesiPerdaganganController::class, 'edit'])->name('master.lain.sesi.edit');
    $route->put('/master/lain/sesi/{sesi}', [MasterSesiPerdaganganController::class, 'update'])->name('master.lain.sesi.update');
    $route->delete('/master/lain/sesi/{sesi}', [MasterSesiPerdaganganController::class, 'destroy'])->name('master.lain.sesi.destroy');

    //// Menu Master Data -> Lain -> Rekening Bank
    $route->get('/master/lain/rekening', [RekeningBankAdminController::class, 'index'])->name('master.lain.rekening');
    $route->get('/master/lain/rekening/create', [RekeningBankAdminController::class, 'create'])->name('master.lain.rekening.create');
    $route->post('/master/lain/rekening', [RekeningBankAdminController::class, 'store'])->name('master.lain.rekening.store');
    $route->get('/master/lain/rekening/{rekening}', [RekeningBankAdminController::class, 'show'])->name('master.lain.rekening.show');
    $route->get('/master/lain/rekening/{rekening}/edit', [RekeningBankAdminController::class, 'edit'])->name('master.lain.rekening.edit');
    $route->put('/master/lain/rekening/{rekening}', [RekeningBankAdminController::class, 'update'])->name('master.lain.rekening.update');
    $route->delete('/master/lain/rekening/{rekening}', [RekeningBankAdminController::class, 'destroy'])->name('master.lain.rekening.destroy');

    //// Menu Master Data -> Lain -> Komoditas
    $route->get('/master/lain/komoditas/cek-satuan', [KomoditasController::class, 'check_satuan'])->name('master.lain.komoditas.check_satuan');

    $route->get('/master/lain/komoditas', [KomoditasController::class, 'index'])->name('master.lain.komoditas');
    $route->get('/master/lain/komoditas/create', [KomoditasController::class, 'create'])->name('master.lain.komoditas.create');
    $route->post('/master/lain/komoditas', [KomoditasController::class, 'store'])->name('master.lain.komoditas.store');
    $route->get('/master/lain/komoditas/{komoditas}', [KomoditasController::class, 'show'])->name('master.lain.komoditas.show');
    $route->get('/master/lain/komoditas/{komoditas}/edit', [KomoditasController::class, 'edit'])->name('master.lain.komoditas.edit');
    $route->put('/master/lain/komoditas/{komoditas}', [KomoditasController::class, 'update'])->name('master.lain.komoditas.update');
    $route->delete('/master/lain/komoditas/{komoditas}', [KomoditasController::class, 'destroy'])->name('master.lain.komoditas.destroy');

    //// Menu Master Data -> Lain -> Dokumen Persyaratan
    $route->get('/master/lain/dokumen_persyaratan', [DokumenPersyaratanController::class, 'index'])->name('master.lain.dokumen_persyaratan');
    $route->get('/master/lain/dokumen_persyaratan/create', [DokumenPersyaratanController::class, 'create'])->name('master.lain.dokumen_persyaratan.create');
    $route->post('/master/lain/dokumen_persyaratan', [DokumenPersyaratanController::class, 'store'])->name('master.lain.dokumen_persyaratan.store');
    $route->get('/master/lain/dokumen_persyaratan/{jenisDokumen}', [DokumenPersyaratanController::class, 'show'])->name('master.lain.dokumen_persyaratan.show');
    $route->get('/master/lain/dokumen_persyaratan/{jenisDokumen}/edit', [DokumenPersyaratanController::class, 'edit'])->name('master.lain.dokumen_persyaratan.edit');
    $route->put('/master/lain/dokumen_persyaratan/{jenisDokumen}', [DokumenPersyaratanController::class, 'update'])->name('master.lain.dokumen_persyaratan.update');
    $route->delete('/master/lain/dokumen_persyaratan/{jenisDokumen}', [DokumenPersyaratanController::class, 'destroy'])->name('master.lain.dokumen_persyaratan.destroy');

    //// Menu Master Data -> Lain -> Pengaturan Hari Libur
    $route->get('/master/lain/hari_libur', [PengaturanHariLiburController::class, 'index'])->name('master.lain.hari_libur');
    $route->get('/master/lain/hari_libur/create', [PengaturanHariLiburController::class, 'create'])->name('master.lain.hari_libur.create');
    $route->post('/master/lain/hari_libur', [PengaturanHariLiburController::class, 'store'])->name('master.lain.hari_libur.store');
    $route->get('/master/lain/hari_libur/{hari_libur}', [PengaturanHariLiburController::class, 'show'])->name('master.lain.hari_libur.show');
    $route->get('/master/lain/hari_libur/{hari_libur}/edit', [PengaturanHariLiburController::class, 'edit'])->name('master.lain.hari_libur.edit');
    $route->put('/master/lain/hari_libur/{hari_libur}', [PengaturanHariLiburController::class, 'update'])->name('master.lain.hari_libur.update');
    $route->delete('/master/lain/hari_libur/{hari_libur}', [PengaturanHariLiburController::class, 'destroy'])->name('master.lain.hari_libur.destroy');

    // Menu Transaksi
    $route->get('/transaksi', TransaksiPasarLelangController::class)->name('transaksi');

    $route->get('/transaksi/lelang_baru/option', [LelangBaruController::class, 'option'])->name('transaksi.lelang_baru.option');

    $route->get('/transaksi/lelang_baru', [LelangBaruController::class, 'index'])->name('transaksi.lelang_baru');
    $route->get('/transaksi/lelang_baru/create', [LelangBaruController::class, 'create'])->name('transaksi.lelang_baru.create');
    $route->post('/transaksi/lelang_baru', [LelangBaruController::class, 'store'])->name('transaksi.lelang_baru.store');
    $route->get('/transaksi/lelang_baru/{lelang}', [LelangBaruController::class, 'show'])->name('transaksi.lelang_baru.show');
    $route->get('/transaksi/lelang_baru/{lelang}/edit', [LelangBaruController::class, 'edit'])->name('transaksi.lelang_baru.edit');
    $route->put('/transaksi/lelang_baru/{lelang}', [LelangBaruController::class, 'update'])->name('transaksi.lelang_baru.update');
    $route->delete('/transaksi/lelang_baru/{lelang}', [LelangBaruController::class, 'destroy'])->name('transaksi.lelang_baru.destroy');

    $route->get('/transaksi/lelang_baru/{lelang}/file', [DokumenProdukLelangController::class, 'index'])->name('transaksi.lelang_baru.file');
    $route->get('/transaksi/lelang_baru/{lelang}/file/create', [DokumenProdukLelangController::class, 'create'])->name('transaksi.lelang_baru.file.create');
    $route->post('/transaksi/lelang_baru/{lelang}/file', [DokumenProdukLelangController::class, 'store'])->name('transaksi.lelang_baru.file.store');
    $route->get('/transaksi/lelang_baru/{lelang}/file/{file}', [DokumenProdukLelangController::class, 'show'])->name('transaksi.lelang_baru.file.show');
    $route->get('/transaksi/lelang_baru/{lelang}/file/{file}/edit', [DokumenProdukLelangController::class, 'edit'])->name('transaksi.lelang_baru.file.edit');
    $route->put('/transaksi/lelang_baru/{lelang}/file/{file}', [DokumenProdukLelangController::class, 'update'])->name('transaksi.lelang_baru.file.update');
    $route->delete('/transaksi/lelang_baru/{lelang}/file/{file}', [DokumenProdukLelangController::class, 'destroy'])->name('transaksi.lelang_baru.file.destroy');

    $route->get('/transaksi/verifikasi_lelang', [VerifikasiLelangController::class, 'index'])->name('transaksi.verifikasi_lelang');
    $route->get('/transaksi/verifikasi_lelang/ditolak', [VerifikasiLelangController::class, 'index_ditolak'])->name('transaksi.verifikasi_lelang.ditolak');
    $route->get('/transaksi/verifikasi_lelang/ditolak/{lelang}', [VerifikasiLelangController::class, 'show_ditolak'])->name('transaksi.verifikasi_lelang.show.ditolak');
    $route->put('/transaksi/verifikasi_lelang/ditolak/{lelang}', [VerifikasiLelangController::class, 'cancel_ditolak'])->name('transaksi.verifikasi_lelang.cancel.ditolak');
    $route->get('/transaksi/verifikasi_lelang/{lelang}', [VerifikasiLelangController::class, 'show'])->name('transaksi.verifikasi_lelang.show');
    $route->post('/transaksi/verifikasi_lelang/{lelang}/edit', [VerifikasiLelangController::class, 'confirmation'])->name('transaksi.verifikasi_lelang.confirmation');

    $route->get('/transaksi/list_lelang', [DaftarLelangController::class, 'index'])->name('transaksi.lelang_list');
    $route->get('/transaksi/list_lelang/{lelang}', [DaftarLelangController::class, 'show'])->name('transaksi.lelang_list.show');
    $route->get('/transaksi/list_lelang/{lelang}/edit', [DaftarLelangController::class, 'edit'])->name('transaksi.lelang_list.edit');
    $route->put('/transaksi/list_lelang/{lelang}', [DaftarLelangController::class, 'update'])->name('transaksi.lelang_list.update');
    $route->delete('/transaksi/list_lelang/{lelang}', [DaftarLelangController::class, 'destroy'])->name('transaksi.lelang_list.destroy');

    $route->get('/transaksi/list_lelang/{lelang}/file', [DokumenProdukLelangListController::class, 'index'])->name('transaksi.lelang_list.file');
    $route->get('/transaksi/list_lelang/{lelang}/file/create', [DokumenProdukLelangListController::class, 'create'])->name('transaksi.lelang_list.file.create');
    $route->post('/transaksi/list_lelang/{lelang}/file', [DokumenProdukLelangListController::class, 'store'])->name('transaksi.lelang_list.file.store');
    $route->get('/transaksi/list_lelang/{lelang}/file/{file}', [DokumenProdukLelangListController::class, 'show'])->name('transaksi.lelang_list.file.show');
    $route->get('/transaksi/list_lelang/{lelang}/file/{file}/edit', [DokumenProdukLelangListController::class, 'edit'])->name('transaksi.lelang_list.file.edit');
    $route->put('/transaksi/list_lelang/{lelang}/file/{file}', [DokumenProdukLelangListController::class, 'update'])->name('transaksi.lelang_list.file.update');
    $route->delete('/transaksi/list_lelang/{lelang}/file/{file}', [DokumenProdukLelangListController::class, 'destroy'])->name('transaksi.lelang_list.file.destroy');

    $route->get('/transaksi/lelang/cek_penawaran_pada_harga_satuan_id', [DaftarLelangController::class, 'penawaranPadaHargaSatuan'])->name('transaksi.api.penawaranPadaHargaSatuan');

    //Menu Administrasi
    $route->get('/administrasi', AdministrasiPasarLelangController::class)->name('administrasi');

    /// Menu Administrasi -> Kas dan Bank
    $route->get('/administrasi/kas_bank', KasBankController::class)->name('administrasi.kas_bank');

    $route->get('/administrasi/kas_bank/penerimaan', [PenerimaanKasBankController::class, 'index'])->name('administrasi.kas_bank.penerimaan.index');
    $route->get('/administrasi/kas_bank/penerimaan/create', [PenerimaanKasBankController::class, 'create'])->name('administrasi.kas_bank.penerimaan.create');
    $route->get('/administrasi/kas_bank/penerimaan/create/api', [PenerimaanKasBankController::class, 'create_api'])->name('administrasi.kas_bank.penerimaan.create_api');
    $route->post('/administrasi/kas_bank/penerimaan', [PenerimaanKasBankController::class, 'store'])->name('administrasi.kas_bank.penerimaan.store');
    $route->get('/administrasi/kas_bank/penerimaan/{keuangan}', [PenerimaanKasBankController::class, 'show'])->name('administrasi.kas_bank.penerimaan.show');
    $route->get('/administrasi/kas_bank/penerimaan/{keuangan}/edit', [PenerimaanKasBankController::class, 'edit'])->name('administrasi.kas_bank.penerimaan.edit');
    $route->put('/administrasi/kas_bank/penerimaan/{keuangan}', [PenerimaanKasBankController::class, 'update'])->name('administrasi.kas_bank.penerimaan.update');
    $route->delete('/administrasi/kas_bank/penerimaan/{keuangan}', [PenerimaanKasBankController::class, 'destroy'])->name('administrasi.kas_bank.penerimaan.destroy');

    $route->get('/administrasi/kas_bank/verifikasi/ditolak', [VerifikasiKasBankController::class, 'index_ditolak'])->name('administrasi.kas_bank.verifikasi.index_ditolak');
    $route->get('/administrasi/kas_bank/verifikasi/ditolak/{keuangan}', [VerifikasiKasBankController::class, 'show_ditolak'])->name('administrasi.kas_bank.verifikasi.show_ditolak');

    $route->get('/administrasi/kas_bank/verifikasi', [VerifikasiKasBankController::class, 'index'])->name('administrasi.kas_bank.verifikasi.index');
    $route->get('/administrasi/kas_bank/verifikasi/{keuangan}', [VerifikasiKasBankController::class, 'show'])->name('administrasi.kas_bank.verifikasi.show');
    $route->put('/administrasi/kas_bank/verifikasi/{keuangan}', [VerifikasiKasBankController::class, 'confirmation'])->name('administrasi.kas_bank.verifikasi.confirmation');
    $route->put('/administrasi/kas_bank/verifikasi/{keuangan}/ulang', [VerifikasiKasBankController::class, 'confirmation_ulang'])->name('administrasi.kas_bank.verifikasi.confirmation_ulang');

    $route->get('/administrasi/kas_bank/list', [ListKasBankController::class, 'index'])->name('administrasi.kas_bank.list.index');
    $route->get('/administrasi/kas_bank/list/{keuangan}', [ListKasBankController::class, 'show'])->name('administrasi.kas_bank.list.show');

    /// Menu Administrasi -> Gudang
    $route->get('/administrasi/gudang', GudangController::class)->name('administrasi.gudang');

    $route->get('/administrasi/gudang/penerimaan', [PenerimaanGudangController::class, 'index'])->name('administrasi.gudang.penerimaan.index');
    $route->get('/administrasi/gudang/penerimaan/create', [PenerimaanGudangController::class, 'create'])->name('administrasi.gudang.penerimaan.create');
    $route->post('/administrasi/gudang/penerimaan', [PenerimaanGudangController::class, 'store'])->name('administrasi.gudang.penerimaan.store');
    $route->get('/administrasi/gudang/penerimaan/{gudang}', [PenerimaanGudangController::class, 'show'])->name('administrasi.gudang.penerimaan.show');
    $route->get('/administrasi/gudang/penerimaan/{gudang}/edit', [PenerimaanGudangController::class, 'edit'])->name('administrasi.gudang.penerimaan.edit');
    $route->put('/administrasi/gudang/penerimaan/{gudang}', [PenerimaanGudangController::class, 'update'])->name('administrasi.gudang.penerimaan.update');
    $route->delete('/administrasi/gudang/penerimaan/{gudang}', [PenerimaanGudangController::class, 'destroy'])->name('administrasi.gudang.penerimaan.destroy');

    $route->get('/administrasi/gudang/verifikasi/ditolak', [VerifikasiGudangController::class, 'index_ditolak'])->name('administrasi.gudang.verifikasi.index_ditolak');
    $route->get('/administrasi/gudang/verifikasi/ditolak/{gudang}', [VerifikasiGudangController::class, 'show_ditolak'])->name('administrasi.gudang.verifikasi.show_ditolak');
    $route->get('/administrasi/gudang/verifikasi', [VerifikasiGudangController::class, 'index'])->name('administrasi.gudang.verifikasi.index');
    $route->get('/administrasi/gudang/verifikasi/{gudang}', [VerifikasiGudangController::class, 'show'])->name('administrasi.gudang.verifikasi.show');
    $route->put('/administrasi/gudang/verifikasi/{gudang}', [VerifikasiGudangController::class, 'confirmation'])->name('administrasi.gudang.verifikasi.confirmation');
    $route->put('/administrasi/gudang/verifikasi/{gudang}/ulang', [VerifikasiGudangController::class, 'confirmation_ulang'])->name('administrasi.gudang.verifikasi.confirmation_ulang');

    $route->get('/administrasi/gudang/list', [ListGudangController::class, 'index'])->name('administrasi.gudang.list.index');
    $route->get('/administrasi/gudang/list/{gudang}', [ListGudangController::class, 'show'])->name('administrasi.gudang.list.show');

    /// Menu Administrasi -> Jaminan Lelang
    $route->get('/administrasi/jaminan', JaminanLelangController::class)->name('administrasi.jaminan');
    $route->get('/administrasi/jaminan/create', [GudangController::class, 'create'])->name('administrasi.gudang.create');
    $route->post('/administrasi/jaminan', [GudangController::class, 'store'])->name('administrasi.gudang.store');
    $route->get('/administrasi/jaminan/{kas}', [GudangController::class, 'show'])->name('administrasi.gudang.show');
    $route->get('/administrasi/jaminan/{kas}/edit', [GudangController::class, 'edit'])->name('administrasi.gudang.edit');
    $route->put('/administrasi/jaminan/{kas}', [GudangController::class, 'update'])->name('administrasi.gudang.update');
    $route->delete('/administrasi/jaminan/{kas}', [GudangController::class, 'destroy'])->name('administrasi.gudang.destroy');

    // Menu Operational
    $route->get('/operational', OperationalPasarLelangController::class)->name('operational');

    // Menu Laporan
    $route->get('/laporan', LaporanController::class)->name('laporan');
    $route->get('/laporan/jaminan', LaporanJaminanController::class)->name('laporan.jaminan');
    $route->get('/laporan/transaksi_lelang', LaporanTransaksiLelangController::class)->name('laporan.transaksi_lelang');
    $route->get('/laporan/transaksi_bank', LaporanTransaksiBankController::class)->name('laporan.transaksi_bank');

    // Menu Lelang Online
    $route->get('/online', LelangOnlineController::class)->name('online');

    $route->get('/online/event', [EventLelangOnlineController::class, 'index'])->name('online.event');
    $route->get('/online/event/{event}', [EventLelangOnlineController::class, 'show'])->name('online.event.show');

    $route->get('/online/event/{event}/produk', [EventLelangOnlineController::class, 'produk'])->name('online.event.produk');
    $route->get('/online/event/{event}/produk/{lelang}', [EventLelangOnlineController::class, 'produk_show'])->name('online.event.produk.show');
    $route->get('/online/event/{event}/produk/{lelang}/sesi', [EventLelangOnlineController::class, 'produk_sesi'])->name('online.event.produk.sesi');

    $route->get('/online/event/{event}/anggota', [AnggotaEventLelangOnlineController::class, 'index'])->name('online.event.anggota');
    $route->get('/online/event/{event}/anggota/create', [AnggotaEventLelangOnlineController::class, 'create'])->name('online.event.anggota.create');
    $route->post('/online/event/{event}/anggota', [AnggotaEventLelangOnlineController::class, 'store'])->name('online.event.anggota.store');
    $route->get('/online/event/{event}/anggota/{anggota}', [AnggotaEventLelangOnlineController::class, 'show'])->name('online.event.anggota.show');
    $route->get('/online/event/{event}/anggota/{anggota}/edit', [AnggotaEventLelangOnlineController::class, 'edit'])->name('online.event.anggota.edit');
    $route->put('/online/event/{event}/anggota/{anggota}/', [AnggotaEventLelangOnlineController::class, 'update'])->name('online.event.anggota.update');
    $route->delete('/online/event/{event}/anggota/{anggota}', [AnggotaEventLelangOnlineController::class, 'destroy'])->name('online.event.anggota.destroy');


    // Menu Lelang Offline
    $route->get('/offline', LelangOfflineController::class)->name('offline');

    $route->get('/offline/profile', [OfflineProfileController::class, 'index'])->name('offline.profile');
    $route->get('/offline/profile/create', [OfflineProfileController::class, 'create'])->name('offline.profile.create');
    $route->post('/offline/profile', [OfflineProfileController::class, 'store'])->name('offline.profile.store');
    $route->get('/offline/profile/{profile}', [OfflineProfileController::class, 'show'])->name('offline.profile.show');
    $route->get('/offline/profile/{profile}/edit', [OfflineProfileController::class, 'edit'])->name('offline.profile.edit');
    $route->put('/offline/profile/{profile}', [OfflineProfileController::class, 'update'])->name('offline.profile.update');
    $route->delete('/offline/profile/{profile}', [OfflineProfileController::class, 'destroy'])->name('offline.profile.destroy');

    $route->get('/offline/operator', [OperatorPasarLelangController::class, 'index'])->name('offline.operator');
    $route->get('/offline/operator/create', [OperatorPasarLelangController::class, 'create'])->name('offline.operator.create');
    $route->post('/offline/operator', [OperatorPasarLelangController::class, 'store'])->name('offline.operator.store');
    $route->get('/offline/operator/{operator}', [OperatorPasarLelangController::class, 'show'])->name('offline.operator.show');
    $route->get('/offline/operator/{operator}/edit', [OperatorPasarLelangController::class, 'edit'])->name('offline.operator.edit');
    $route->put('/offline/operator/{operator}', [OperatorPasarLelangController::class, 'update'])->name('offline.operator.update');
    $route->delete('/offline/operator/{operator}', [OperatorPasarLelangController::class, 'destroy'])->name('offline.operator.destroy');

    $route->get('/offline/event', [EventLelangController::class, 'index'])->name('offline.event');
    $route->get('/offline/event/create', [EventLelangController::class, 'create'])->name('offline.event.create');
    $route->post('/offline/event', [EventLelangController::class, 'store'])->name('offline.event.store');
    $route->get('/offline/event/{event}', [EventLelangController::class, 'show'])->name('offline.event.show');
    $route->get('/offline/event/{event}/edit', [EventLelangController::class, 'edit'])->name('offline.event.edit');
    $route->get('/offline/event/{event}/status', [EventLelangController::class, 'edit_status'])->name('offline.event.edit_status');
    $route->put('/offline/event/{event}/status', [EventLelangController::class, 'update_status'])->name('offline.event.update_status');
    $route->put('/offline/event/{event}', [EventLelangController::class, 'update'])->name('offline.event.update');
    $route->delete('/offline/event/{event}', [EventLelangController::class, 'destroy'])->name('offline.event.destroy');

    $route->get('/offline/event/{event}/produk', [EventLelangProdukController::class, 'index'])->name('offline.event.produk');
    $route->get('/offline/event/{event}/produk/{lelang}', [EventLelangProdukController::class, 'show'])->name('offline.event.produk.show');

    $route->get('/offline/event/{event}/produk/{lelang}/sesi', [EventLelangProdukController::class, 'sesi'])->name('offline.event.produk.sesi');
    $route->get('/offline/event/{event}/produk/{lelang}/doc/{file}', [EventLelangProdukController::class, 'sesi_doc'])->name('offline.event.produk.sesi_doc');
    $route->post('/offline/event/{event}/produk/{lelang}/sesi/api', [EventLelangProdukController::class, 'sesi_api'])->name('offline.event.produk.sesi.api');

    $route->get('/offline/event/{event}/anggota', [EventLelangAnggotaController::class, 'index'])->name('offline.event.anggota');
    $route->get('/offline/event/{event}/anggota/create', [EventLelangAnggotaController::class, 'create'])->name('offline.event.anggota.create');
    $route->post('/offline/event/{event}/anggota/{member}choose', [EventLelangAnggotaController::class, 'store_anggota'])->name('offline.event.anggota.store_anggota');
    $route->post('/offline/event/{event}/anggota', [EventLelangAnggotaController::class, 'store'])->name('offline.event.anggota.store');
    $route->get('/offline/event/{event}/anggota/{anggota}', [EventLelangAnggotaController::class, 'show'])->name('offline.event.anggota.show');
    $route->get('/offline/event/{event}/anggota/{anggota}/edit', [EventLelangAnggotaController::class, 'edit'])->name('offline.event.anggota.edit');
    $route->put('/offline/event/{event}/anggota/{anggota}/', [EventLelangAnggotaController::class, 'update'])->name('offline.event.anggota.update');
    $route->delete('/offline/event/{event}/anggota/{anggota}', [EventLelangAnggotaController::class, 'destroy'])->name('offline.event.anggota.destroy');

    // Menu Konfigurasi
    $route->get('/konfigurasi', KonfigurasiController::class)->name('konfigurasi');
});
