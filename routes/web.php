<?php

use App\Http\Controllers\Administrasi\AdministrasiPasarLelangController;
use App\Http\Controllers\Administrasi\Gudang\GudangController;
use App\Http\Controllers\Administrasi\Gudang\ListGudangController;
use App\Http\Controllers\Administrasi\Gudang\PenerimaanGudangController;
use App\Http\Controllers\Administrasi\Gudang\VerifikasiGudangController;
use App\Http\Controllers\Administrasi\JaminanLelang\JaminanLelangController;
use App\Http\Controllers\Administrasi\JaminanLelang\ListJaminanController;
use App\Http\Controllers\Administrasi\JaminanLelang\ListJaminanPengeluaranController;
use App\Http\Controllers\Administrasi\JaminanLelang\PenerimaanJaminanController;
use App\Http\Controllers\Administrasi\JaminanLelang\PenerimaanJaminanDepositoController;
use App\Http\Controllers\Administrasi\JaminanLelang\PenerimaanJaminanObligasiController;
use App\Http\Controllers\Administrasi\JaminanLelang\PenerimaanJaminanResiGudangController;
use App\Http\Controllers\Administrasi\JaminanLelang\PenerimaanJaminanSahamController;
use App\Http\Controllers\Administrasi\JaminanLelang\PenerimaanKasJaminanController;
use App\Http\Controllers\Administrasi\JaminanLelang\PenerimaanKomoditasJaminanController;
use App\Http\Controllers\Administrasi\JaminanLelang\PengeluaranJaminanController;
use App\Http\Controllers\Administrasi\JaminanLelang\VerifikasiJaminanController;
use App\Http\Controllers\Administrasi\JaminanLelang\VerifikasiPengeluaranJaminanController;
use App\Http\Controllers\Administrasi\KasBank\FileKeuanganController;
use App\Http\Controllers\Administrasi\KasBank\KasBankController;
use App\Http\Controllers\Administrasi\KasBank\ListKasBankController;
use App\Http\Controllers\Administrasi\KasBank\PenerimaanKasBankController;
use App\Http\Controllers\Administrasi\KasBank\VerifikasiKasBankController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\BlogKategoriController;
use App\Http\Controllers\Blog\BlogPostController;
use App\Http\Controllers\Blog\BlogPostMetaController;
use App\Http\Controllers\Blog\BlogTagController;
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
use App\Http\Controllers\Operational\OperationalListTransaksiLelangController;
use App\Http\Controllers\Operational\OperationalPasarLelangController;
use App\Http\Controllers\Operational\OperationalTransaksiLelangController;
use App\Http\Controllers\Operational\OperationalVerifikasiTransaksiLelangController;
use App\Http\Controllers\Konfigurasi\RoleController;
use App\Http\Controllers\Konfigurasi\MutuController;
use App\Http\Controllers\Konfigurasi\AdminController;
use App\Http\Controllers\Konfigurasi\Aplikasi\AplikasiController;
use App\Http\Controllers\Konfigurasi\Aplikasi\CarouselController;
use App\Http\Controllers\Konfigurasi\Aplikasi\KonfigurasiAplikasiController;
use App\Http\Controllers\Konfigurasi\Aplikasi\WebLinkController;
use App\Http\Controllers\Konfigurasi\Area\AreaController;
use App\Http\Controllers\Konfigurasi\Area\DesaController;
use App\Http\Controllers\Konfigurasi\Area\KabupatenController;
use App\Http\Controllers\Konfigurasi\Area\KecamatanController;
use App\Http\Controllers\Konfigurasi\Area\ProvinsiController;
use App\Http\Controllers\Konfigurasi\DanaKeuanganController;
use App\Http\Controllers\Konfigurasi\Jenis\JenisController;
use App\Http\Controllers\Konfigurasi\Jenis\JenisHargaController;
use App\Http\Controllers\Konfigurasi\Jenis\JenisInisiasiController;
use App\Http\Controllers\Konfigurasi\Jenis\JenisPerdaganganController;
use App\Http\Controllers\Konfigurasi\Laporan\KonfigurasiLaporanController;
use App\Http\Controllers\Konfigurasi\Laporan\KonfigurasiLaporanPerjanjianJualBeliController;
use App\Http\Controllers\Konfigurasi\RekeningPusatController;
use App\Http\Controllers\Konfigurasi\Status\StatusController;
use App\Http\Controllers\Konfigurasi\Status\StatusEventLelangController;
use App\Http\Controllers\Konfigurasi\Status\StatusLelangController;
use App\Http\Controllers\Konfigurasi\Status\StatusMemberController;
use App\Http\Controllers\Laporan\LaporanDaftarAnggota\LaporanDaftarAnggotaController;
use App\Http\Controllers\Laporan\LaporanEventOffline\LaporanEventLelangController;
use App\Http\Controllers\Laporan\LaporanLelang\LaporanLelangController;
use App\Http\Controllers\LelangOffline\HistoryOfflineController;
use App\Http\Controllers\LelangOffline\ListOfflineController;
use App\Http\Controllers\LelangOnline\HistoryOnlineController;
use App\Http\Controllers\LelangOnline\ListOnlineController;
use App\Http\Controllers\Saldo\SaldoController;
use App\Http\Controllers\Transaksi\DaftarLelangController;
use App\Http\Controllers\Transaksi\DokumenProdukLelangController;
use App\Http\Controllers\Transaksi\DokumenProdukLelangListController;
use App\Http\Controllers\Transaksi\LelangBaruController;
use App\Http\Controllers\Transaksi\TransaksiPasarLelangController;
use App\Http\Controllers\Transaksi\VerifikasiLelangController;
use App\Http\Controllers\User\Kontrak\KontrakUserController;
use App\Http\Controllers\User\Kontrak\KontrakUserListController;
use App\Http\Controllers\User\Kontrak\KontrakUserPengajuanController;
use App\Http\Controllers\User\Lelang\LelangUserController;
use App\Http\Controllers\User\Lelang\LelangUserDokumenController;
use App\Http\Controllers\User\Lelang\LelangUserListController;
use App\Http\Controllers\User\Lelang\LelangUserPengajuanController;
use App\Http\Controllers\User\Lelang\LelangUserTransaksiController;
use App\Http\Controllers\Welcome\WelcomeController;
use App\Http\Controllers\Welcome\ArtikelController;
use App\Http\Controllers\Welcome\WelcomeLelangController;
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

Route::get('/', WelcomeController::class)->name('welcome');

Auth::routes([
    'reset' => false,
    'verify' => false
]);

Route::middleware('auth')->group(function ($route) {
    $route->get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])->name('notifikasi');
    $route->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    $route->get('/home/api', [App\Http\Controllers\HomeController::class, 'api'])->name('home.api');

    $route->get('/profil', [App\Http\Controllers\HomeController::class, 'profil'])->name('home.profil');
    $route->put('/profil', [App\Http\Controllers\HomeController::class, 'profil_update'])->name('home.profil.update');
    $route->get('/profil/edit', [App\Http\Controllers\HomeController::class, 'profil_edit'])->name('home.profil.edit');

    $route->get('/profil/area', [App\Http\Controllers\Profil\AreaProfileController::class, 'index'])->name('home.profil.area');
    $route->get('/profil/area/create', [App\Http\Controllers\Profil\AreaProfileController::class, 'create'])->name('home.profil.area.create');
    $route->get('/profil/area/create/api', [App\Http\Controllers\Profil\AreaProfileController::class, 'api'])->name('home.profil.area.api');
    $route->post('/profil/area', [App\Http\Controllers\Profil\AreaProfileController::class, 'store'])->name('home.profil.area.store');
    $route->get('/profil/area/{areaMember}', [App\Http\Controllers\Profil\AreaProfileController::class, 'show'])->name('home.profil.area.show');
    $route->get('/profil/area/{areaMember}/edit', [App\Http\Controllers\Profil\AreaProfileController::class, 'edit'])->name('home.profil.area.edit');
    $route->put('/profil/area/{areaMember}', [App\Http\Controllers\Profil\AreaProfileController::class, 'update'])->name('home.profil.area.update');
    $route->delete('/profil/area/{areaMember}', [App\Http\Controllers\Profil\AreaProfileController::class, 'destroy'])->name('home.profil.area.destroy');

    $route->get('/profil/rekening_bank', [App\Http\Controllers\Profil\RekeningBankProfileController::class, 'index'])->name('home.profil.rekening_bank');
    $route->get('/profil/rekening_bank/create', [App\Http\Controllers\Profil\RekeningBankProfileController::class, 'create'])->name('home.profil.rekening_bank.create');
    $route->post('/profil/rekening_bank', [App\Http\Controllers\Profil\RekeningBankProfileController::class, 'store'])->name('home.profil.rekening_bank.store');
    $route->get('/profil/rekening_bank/{rekeningBank}', [App\Http\Controllers\Profil\RekeningBankProfileController::class, 'show'])->name('home.profil.rekening_bank.show');
    $route->get('/profil/rekening_bank/{rekeningBank}/edit', [App\Http\Controllers\Profil\RekeningBankProfileController::class, 'edit'])->name('home.profil.rekening_bank.edit');
    $route->put('/profil/rekening_bank/{rekeningBank}', [App\Http\Controllers\Profil\RekeningBankProfileController::class, 'update'])->name('home.profil.rekening_bank.update');
    $route->delete('/profil/rekening_bank/{rekeningBank}', [App\Http\Controllers\Profil\RekeningBankProfileController::class, 'destroy'])->name('home.profil.rekening_bank.destroy');

    $route->get('/profil/rekening_bank/{rekeningBank}/get-saldo', [App\Http\Controllers\Profil\RekeningBankProfileController::class, 'get_saldo'])->name('home.profil.rekening_bank.get_saldo');

    $route->get('/profil/dokumen', [App\Http\Controllers\Profil\DokumenProfileController::class, 'index'])->name('home.profil.dokumen');
    $route->get('/profil/dokumen/create', [App\Http\Controllers\Profil\DokumenProfileController::class, 'create'])->name('home.profil.dokumen.create');
    $route->post('/profil/dokumen', [App\Http\Controllers\Profil\DokumenProfileController::class, 'store'])->name('home.profil.dokumen.store');
    $route->get('/profil/dokumen/{dokumenMember}', [App\Http\Controllers\Profil\DokumenProfileController::class, 'show'])->name('home.profil.dokumen.show');
    $route->get('/profil/dokumen/{dokumenMember}/edit', [App\Http\Controllers\Profil\DokumenProfileController::class, 'edit'])->name('home.profil.dokumen.edit');
    $route->put('/profil/dokumen/{dokumenMember}', [App\Http\Controllers\Profil\DokumenProfileController::class, 'update'])->name('home.profil.dokumen.update');
    $route->delete('/profil/dokumen/{dokumenMember}', [App\Http\Controllers\Profil\DokumenProfileController::class, 'destroy'])->name('home.profil.dokumen.destroy');

    $route->get('/home/provinsi', [HomeController::class, 'provinsi'])->name('area.provinsi');
    $route->get('/home/kabupaten/{provinsi}', [HomeController::class, 'kabupaten'])->name('area.kabupaten');
    $route->get('/home/kecamatan/{kabupaten}', [HomeController::class, 'kecamatan'])->name('area.kecamatan');
    $route->get('/home/desa/{kecamatan}', [HomeController::class, 'desa'])->name('area.desa');

    // Menu Saldo
    $route->get('/home/saldo', [SaldoController::class, 'saldo'])->name('home.saldo');
    $route->get('/home/saldo/rincian', [SaldoController::class, 'rincian'])->name('home.saldo.rincian');
    $route->get('/home/saldo/deposit', [SaldoController::class, 'deposit'])->name('home.saldo.deposit');
    $route->post('/home/saldo/deposit', [SaldoController::class, 'deposit_store'])->name('home.saldo.deposit_store');
    $route->get('/home/saldo/withdraw', [SaldoController::class, 'withdraw'])->name('home.saldo.withdraw');
    $route->post('/home/saldo/withdraw', [SaldoController::class, 'withdraw_store'])->name('home.saldo.withdraw_store');
    $route->get('/home/saldo/riwayat', [SaldoController::class, 'riwayat'])->name('home.saldo.riwayat');

    $route->get('/home/saldo/jaminan', [SaldoController::class, 'jaminan'])->name('home.saldo.jaminan');
    $route->get('/home/saldo/jaminan/deposit', [SaldoController::class, 'jaminan_deposit'])->name('home.saldo.jaminan.deposit');
    $route->post('/home/saldo/jaminan/deposit', [SaldoController::class, 'jaminan_deposit_store'])->name('home.saldo.deposit_jaminan_store');
    $route->get('/home/saldo/jaminan/withdraw', [SaldoController::class, 'jaminan_withdraw'])->name('home.saldo.jaminan.withdraw');
    $route->post('/home/saldo/jaminan/withdraw', [SaldoController::class, 'jaminan_withdraw_store'])->name('home.saldo.jaminan.withdraw_store');
    $route->get('/home/saldo/jaminan/riwayat', [SaldoController::class, 'jaminan_riwayat'])->name('home.saldo.jaminan.riwayat');
    $route->get('/home/saldo/{keuangan}', [SaldoController::class, 'keuangan_detail'])->name('home.saldo.keuangan_detail');

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

    $route->get('/administrasi/kas_bank/penerimaan/{keuangan}/file', [FileKeuanganController::class, 'index'])->name('administrasi.kas_bank.penerimaan.file.index');
    $route->get('/administrasi/kas_bank/penerimaan/{keuangan}/file/create', [FileKeuanganController::class, 'create'])->name('administrasi.kas_bank.penerimaan.file.create');
    $route->post('/administrasi/kas_bank/penerimaan/{keuangan}/file/', [FileKeuanganController::class, 'store'])->name('administrasi.kas_bank.penerimaan.file.store');
    $route->get('/administrasi/kas_bank/penerimaan/{keuangan}/file/{fileKeuangan}', [FileKeuanganController::class, 'show'])->name('administrasi.kas_bank.penerimaan.file.show');
    $route->get('/administrasi/kas_bank/penerimaan/{keuangan}/file/{fileKeuangan}/edit', [FileKeuanganController::class, 'edit'])->name('administrasi.kas_bank.penerimaan.file.edit');
    $route->put('/administrasi/kas_bank/penerimaan/{keuangan}/file/{fileKeuangan}', [FileKeuanganController::class, 'update'])->name('administrasi.kas_bank.penerimaan.file.update');
    $route->delete('/administrasi/kas_bank/penerimaan/{keuangan}/file/{fileKeuangan}', [FileKeuanganController::class, 'destroy'])->name('administrasi.kas_bank.penerimaan.file.destroy');

    $route->get('/administrasi/kas_bank/verifikasi/ditolak', [VerifikasiKasBankController::class, 'index_ditolak'])->name('administrasi.kas_bank.verifikasi.index_ditolak');
    $route->get('/administrasi/kas_bank/verifikasi/ditolak/{keuangan}', [VerifikasiKasBankController::class, 'show_ditolak'])->name('administrasi.kas_bank.verifikasi.show_ditolak');

    $route->get('/administrasi/kas_bank/verifikasi', [VerifikasiKasBankController::class, 'index'])->name('administrasi.kas_bank.verifikasi.index');
    $route->get('/administrasi/kas_bank/verifikasi/{keuangan}', [VerifikasiKasBankController::class, 'show'])->name('administrasi.kas_bank.verifikasi.show');
    $route->put('/administrasi/kas_bank/verifikasi/{keuangan}', [VerifikasiKasBankController::class, 'confirmation'])->name('administrasi.kas_bank.verifikasi.confirmation');
    $route->put('/administrasi/kas_bank/verifikasi/{keuangan}/ulang', [VerifikasiKasBankController::class, 'confirmation_ulang'])->name('administrasi.kas_bank.verifikasi.confirmation_ulang');

    $route->get('/administrasi/kas_bank/list', [ListKasBankController::class, 'index'])->name('administrasi.kas_bank.list.index');
    $route->get('/administrasi/kas_bank/list/{keuangan}', [ListKasBankController::class, 'show'])->name('administrasi.kas_bank.list.show');

    $route->get('/administrasi/kas_bank/list/{keuangan}/file', [FileKeuanganController::class, 'index_list'])->name('administrasi.kas_bank.list.file.index');
    $route->get('/administrasi/kas_bank/list/{keuangan}/file/{fileKeuangan}', [FileKeuanganController::class, 'show_list'])->name('administrasi.kas_bank.list.file.show');

    $route->get('/administrasi/kas_bank/verifikasi/{keuangan}/file', [FileKeuanganController::class, 'index_verifikasi'])->name('administrasi.kas_bank.verifikasi.file.index');
    $route->get('/administrasi/kas_bank/list/{keuangan}/file/{fileKeuangan}', [FileKeuanganController::class, 'show_verifikasi'])->name('administrasi.kas_bank.verifikasi.file.show');

    /// Menu Administrasi -> Gudang
    $route->get('/administrasi/gudang', GudangController::class)->name('administrasi.gudang');

    /// Menu Administrasi -> Gudang -> Penerimaan
    $route->get('/administrasi/gudang/penerimaan', [PenerimaanGudangController::class, 'index'])->name('administrasi.gudang.penerimaan.index');
    $route->get('/administrasi/gudang/penerimaan/create', [PenerimaanGudangController::class, 'create'])->name('administrasi.gudang.penerimaan.create');
    $route->post('/administrasi/gudang/penerimaan', [PenerimaanGudangController::class, 'store'])->name('administrasi.gudang.penerimaan.store');
    $route->get('/administrasi/gudang/penerimaan/{registrasi}', [PenerimaanGudangController::class, 'show'])->name('administrasi.gudang.penerimaan.show');
    $route->get('/administrasi/gudang/penerimaan/{registrasi}/edit', [PenerimaanGudangController::class, 'edit'])->name('administrasi.gudang.penerimaan.edit');
    $route->put('/administrasi/gudang/penerimaan/{registrasi}', [PenerimaanGudangController::class, 'update'])->name('administrasi.gudang.penerimaan.update');
    $route->delete('/administrasi/gudang/penerimaan/{registrasi}', [PenerimaanGudangController::class, 'destroy'])->name('administrasi.gudang.penerimaan.destroy');

    /// Menu Administrasi -> Gudang -> Verifikasi
    $route->get('/administrasi/gudang/verifikasi/ditolak', [VerifikasiGudangController::class, 'index_ditolak'])->name('administrasi.gudang.verifikasi.index_ditolak');
    $route->get('/administrasi/gudang/verifikasi/ditolak/{registrasi}', [VerifikasiGudangController::class, 'show_ditolak'])->name('administrasi.gudang.verifikasi.show_ditolak');
    $route->get('/administrasi/gudang/verifikasi', [VerifikasiGudangController::class, 'index'])->name('administrasi.gudang.verifikasi.index');
    $route->get('/administrasi/gudang/verifikasi/{registrasi}', [VerifikasiGudangController::class, 'show'])->name('administrasi.gudang.verifikasi.show');
    $route->put('/administrasi/gudang/verifikasi/{registrasi}', [VerifikasiGudangController::class, 'confirmation'])->name('administrasi.gudang.verifikasi.confirmation');
    $route->put('/administrasi/gudang/verifikasi/{registrasi}/ulang', [VerifikasiGudangController::class, 'confirmation_ulang'])->name('administrasi.gudang.verifikasi.confirmation_ulang');

    /// Menu Administrasi -> Gudang -> List
    $route->get('/administrasi/gudang/list', [ListGudangController::class, 'index'])->name('administrasi.gudang.list.index');
    $route->get('/administrasi/gudang/list/{registrasi}', [ListGudangController::class, 'show'])->name('administrasi.gudang.list.show');

    /// Menu Administrasi -> Jaminan Lelang
    $route->get('/administrasi/jaminan', JaminanLelangController::class)->name('administrasi.jaminan');

    /// Menu Administrasi -> Jaminan Lelang -> Verifikasi
    $route->get('/administrasi/jaminan/penerimaan/verifikasi', [VerifikasiJaminanController::class, 'index'])->name('administrasi.jaminan.penerimaan.verifikasi.index');
    $route->get('/administrasi/jaminan/penerimaan/verifikasi/ditolak', [VerifikasiJaminanController::class, 'index_ditolak'])->name('administrasi.jaminan.penerimaan.verifikasi.index_ditolak');
    $route->get('/administrasi/jaminan/penerimaan/verifikasi/ditolak/{detailJaminan}', [VerifikasiJaminanController::class, 'show_ditolak'])->name('administrasi.jaminan.penerimaan.verifikasi.show_ditolak');
    $route->get('/administrasi/jaminan/penerimaan/verifikasi/{detailJaminan}', [VerifikasiJaminanController::class, 'show'])->name('administrasi.jaminan.penerimaan.verifikasi.show');
    $route->put('/administrasi/jaminan/penerimaan/verifikasi/{detailJaminan}', [VerifikasiJaminanController::class, 'confirmation'])->name('administrasi.jaminan.penerimaan.verifikasi.confirmation');
    $route->put('/administrasi/jaminan/penerimaan/verifikasi/{detailJaminan}/ulang', [VerifikasiJaminanController::class, 'confirmation_ulang'])->name('administrasi.jaminan.penerimaan.verifikasi.confirmation_ulang');

    /// Menu Administrasi -> Jaminan Lelang -> List
    $route->get('/administrasi/jaminan/penerimaan/list', [ListJaminanController::class, 'index'])->name('administrasi.jaminan.penerimaan.list.index');
    $route->get('/administrasi/jaminan/penerimaan/list/{detailJaminan}', [ListJaminanController::class, 'show'])->name('administrasi.jaminan.penerimaan.list.show');

    /// Menu Administrasi -> Jaminan Lelang -> Penerimaan
    $route->get('/administrasi/jaminan/penerimaan/create/api', [PenerimaanJaminanController::class, 'api'])->name('administrasi.jaminan.penerimaan.api');
    $route->get('/administrasi/jaminan/penerimaan', [PenerimaanJaminanController::class, 'index'])->name('administrasi.jaminan.penerimaan.index');
    $route->get('/administrasi/jaminan/penerimaan/create', [PenerimaanJaminanController::class, 'create'])->name('administrasi.jaminan.penerimaan.create');
    $route->post('/administrasi/jaminan/penerimaan', [PenerimaanJaminanController::class, 'store'])->name('administrasi.jaminan.penerimaan.store');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}', [PenerimaanJaminanController::class, 'show'])->name('administrasi.jaminan.penerimaan.show');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/edit', [PenerimaanJaminanController::class, 'edit'])->name('administrasi.jaminan.penerimaan.edit');
    $route->put('/administrasi/jaminan/penerimaan/{detailJaminan}', [PenerimaanJaminanController::class, 'update'])->name('administrasi.jaminan.penerimaan.update');
    $route->delete('/administrasi/jaminan/penerimaan/{detailJaminan}', [PenerimaanJaminanController::class, 'destroy'])->name('administrasi.jaminan.penerimaan.destroy');

    /// Menu Administrasi -> Jaminan Lelang -> Penerimaan -> Kas
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/kas', [PenerimaanKasJaminanController::class, 'index'])->name('administrasi.jaminan.penerimaan.kas.index');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/kas/create', [PenerimaanKasJaminanController::class, 'create'])->name('administrasi.jaminan.penerimaan.kas.create');
    $route->post('/administrasi/jaminan/penerimaan{detailJaminan}/kas', [PenerimaanKasJaminanController::class, 'store'])->name('administrasi.jaminan.penerimaan.kas.store');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/kas/{kas}', [PenerimaanKasJaminanController::class, 'show'])->name('administrasi.jaminan.penerimaan.kas.show');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/kas/{kas}/edit', [PenerimaanKasJaminanController::class, 'edit'])->name('administrasi.jaminan.penerimaan.kas.edit');
    $route->put('/administrasi/jaminan/penerimaan/{detailJaminan}/kas/{kas}', [PenerimaanKasJaminanController::class, 'update'])->name('administrasi.jaminan.penerimaan.kas.update');
    $route->delete('/administrasi/jaminan/penerimaan/{detailJaminan}/kas/{kas}', [PenerimaanKasJaminanController::class, 'destroy'])->name('administrasi.jaminan.penerimaan.kas.destroy');

    /// Menu Administrasi -> Jaminan Lelang -> Penerimaan -> Komoditas
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/komoditas', [PenerimaanKomoditasJaminanController::class, 'index'])->name('administrasi.jaminan.penerimaan.komoditas.index');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/komoditas/create', [PenerimaanKomoditasJaminanController::class, 'create'])->name('administrasi.jaminan.penerimaan.komoditas.create');
    $route->post('/administrasi/jaminan/penerimaan{detailJaminan}/komoditas', [PenerimaanKomoditasJaminanController::class, 'store'])->name('administrasi.jaminan.penerimaan.komoditas.store');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/komoditas/{komoditas}', [PenerimaanKomoditasJaminanController::class, 'show'])->name('administrasi.jaminan.penerimaan.komoditas.show');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/komoditas/{komoditas}/edit', [PenerimaanKomoditasJaminanController::class, 'edit'])->name('administrasi.jaminan.penerimaan.komoditas.edit');
    $route->put('/administrasi/jaminan/penerimaan/{detailJaminan}/komoditas/{komoditas}', [PenerimaanKomoditasJaminanController::class, 'update'])->name('administrasi.jaminan.penerimaan.komoditas.update');
    $route->delete('/administrasi/jaminan/penerimaan/{detailJaminan}/komoditas/{komoditas}', [PenerimaanKomoditasJaminanController::class, 'destroy'])->name('administrasi.jaminan.penerimaan.komoditas.destroy');

    /// Menu Administrasi -> Jaminan Lelang -> Penerimaan -> Surat -> Deposito
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/deposito', [PenerimaanJaminanDepositoController::class, 'index'])->name('administrasi.jaminan.penerimaan.deposito.index');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/deposito/create', [PenerimaanJaminanDepositoController::class, 'create'])->name('administrasi.jaminan.penerimaan.deposito.create');
    $route->post('/administrasi/jaminan/penerimaan{detailJaminan}/deposito', [PenerimaanJaminanDepositoController::class, 'store'])->name('administrasi.jaminan.penerimaan.deposito.store');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/deposito/{deposito}', [PenerimaanJaminanDepositoController::class, 'show'])->name('administrasi.jaminan.penerimaan.deposito.show');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/deposito/{deposito}/edit', [PenerimaanJaminanDepositoController::class, 'edit'])->name('administrasi.jaminan.penerimaan.deposito.edit');
    $route->put('/administrasi/jaminan/penerimaan/{detailJaminan}/deposito/{deposito}', [PenerimaanJaminanDepositoController::class, 'update'])->name('administrasi.jaminan.penerimaan.deposito.update');
    $route->delete('/administrasi/jaminan/penerimaan/{detailJaminan}/deposito/{deposito}', [PenerimaanJaminanDepositoController::class, 'destroy'])->name('administrasi.jaminan.penerimaan.deposito.destroy');

    /// Menu Administrasi -> Jaminan Lelang -> Penerimaan -> Surat -> Saham
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/saham', [PenerimaanJaminanSahamController::class, 'index'])->name('administrasi.jaminan.penerimaan.saham.index');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/saham/create', [PenerimaanJaminanSahamController::class, 'create'])->name('administrasi.jaminan.penerimaan.saham.create');
    $route->post('/administrasi/jaminan/penerimaan{detailJaminan}/saham', [PenerimaanJaminanSahamController::class, 'store'])->name('administrasi.jaminan.penerimaan.saham.store');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/saham/{saham}', [PenerimaanJaminanSahamController::class, 'show'])->name('administrasi.jaminan.penerimaan.saham.show');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/saham/{saham}/edit', [PenerimaanJaminanSahamController::class, 'edit'])->name('administrasi.jaminan.penerimaan.saham.edit');
    $route->put('/administrasi/jaminan/penerimaan/{detailJaminan}/saham/{saham}', [PenerimaanJaminanSahamController::class, 'update'])->name('administrasi.jaminan.penerimaan.saham.update');
    $route->delete('/administrasi/jaminan/penerimaan/{detailJaminan}/saham/{saham}', [PenerimaanJaminanSahamController::class, 'destroy'])->name('administrasi.jaminan.penerimaan.saham.destroy');

    /// Menu Administrasi -> Jaminan Lelang -> Penerimaan -> Surat -> Obligasi
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/obligasi', [PenerimaanJaminanObligasiController::class, 'index'])->name('administrasi.jaminan.penerimaan.obligasi.index');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/obligasi/create', [PenerimaanJaminanObligasiController::class, 'create'])->name('administrasi.jaminan.penerimaan.obligasi.create');
    $route->post('/administrasi/jaminan/penerimaan{detailJaminan}/obligasi', [PenerimaanJaminanObligasiController::class, 'store'])->name('administrasi.jaminan.penerimaan.obligasi.store');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/obligasi/{obligasi}', [PenerimaanJaminanObligasiController::class, 'show'])->name('administrasi.jaminan.penerimaan.obligasi.show');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/obligasi/{obligasi}/edit', [PenerimaanJaminanObligasiController::class, 'edit'])->name('administrasi.jaminan.penerimaan.obligasi.edit');
    $route->put('/administrasi/jaminan/penerimaan/{detailJaminan}/obligasi/{obligasi}', [PenerimaanJaminanObligasiController::class, 'update'])->name('administrasi.jaminan.penerimaan.obligasi.update');
    $route->delete('/administrasi/jaminan/penerimaan/{detailJaminan}/obligasi/{obligasi}', [PenerimaanJaminanObligasiController::class, 'destroy'])->name('administrasi.jaminan.penerimaan.obligasi.destroy');

    /// Menu Administrasi -> Jaminan Lelang -> Penerimaan -> Surat -> Resi Gudang
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/resi_gudang', [PenerimaanJaminanResiGudangController::class, 'index'])->name('administrasi.jaminan.penerimaan.resi_gudang.index');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/resi_gudang/create', [PenerimaanJaminanResiGudangController::class, 'create'])->name('administrasi.jaminan.penerimaan.resi_gudang.create');
    $route->post('/administrasi/jaminan/penerimaan{detailJaminan}/resi_gudang', [PenerimaanJaminanResiGudangController::class, 'store'])->name('administrasi.jaminan.penerimaan.resi_gudang.store');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/resi_gudang/{resiGudang}', [PenerimaanJaminanResiGudangController::class, 'show'])->name('administrasi.jaminan.penerimaan.resi_gudang.show');
    $route->get('/administrasi/jaminan/penerimaan/{detailJaminan}/resi_gudang/{resiGudang}/edit', [PenerimaanJaminanResiGudangController::class, 'edit'])->name('administrasi.jaminan.penerimaan.resi_gudang.edit');
    $route->put('/administrasi/jaminan/penerimaan/{detailJaminan}/resi_gudang/{resiGudang}', [PenerimaanJaminanResiGudangController::class, 'update'])->name('administrasi.jaminan.penerimaan.resi_gudang.update');
    $route->delete('/administrasi/jaminan/penerimaan/{detailJaminan}/resi_gudang/{resiGudang}', [PenerimaanJaminanResiGudangController::class, 'destroy'])->name('administrasi.jaminan.penerimaan.resi_gudang.destroy');

    /// Menu Administrasi -> Jaminan Lelang -> Verifikasi Pengeluaran
    $route->get('/administrasi/jaminan/pengeluaran/verifikasi/ditolak', [VerifikasiPengeluaranJaminanController::class, 'index_ditolak'])->name('administrasi.jaminan.pengeluaran.verifikasi.index_ditolak');
    $route->get('/administrasi/jaminan/pengeluaran/verifikasi/ditolak/{pengeluaranJaminan}', [VerifikasiPengeluaranJaminanController::class, 'show_ditolak'])->name('administrasi.jaminan.pengeluaran.verifikasi.show_ditolak');
    $route->get('/administrasi/jaminan/pengeluaran/verifikasi', [VerifikasiPengeluaranJaminanController::class, 'index'])->name('administrasi.jaminan.pengeluaran.verifikasi.index');
    $route->get('/administrasi/jaminan/pengeluaran/verifikasi/{pengeluaranJaminan}', [VerifikasiPengeluaranJaminanController::class, 'show'])->name('administrasi.jaminan.pengeluaran.verifikasi.show');
    $route->put('/administrasi/jaminan/pengeluaran/verifikasi/{pengeluaranJaminan}', [VerifikasiPengeluaranJaminanController::class, 'confirmation'])->name('administrasi.jaminan.pengeluaran.verifikasi.confirmation');
    $route->put('/administrasi/jaminan/pengeluaran/verifikasi/{pengeluaranJaminan}/ulang', [VerifikasiPengeluaranJaminanController::class, 'confirmation_ulang'])->name('administrasi.jaminan.pengeluaran.verifikasi.confirmation_ulang');

    /// Menu Administrasi -> Jaminan Lelang -> List Pengeluaran
    $route->get('/administrasi/jaminan/pengeluaran/list', [ListJaminanPengeluaranController::class, 'index'])->name('administrasi.jaminan.pengeluaran.list.index');
    $route->get('/administrasi/jaminan/pengeluaran/list/{pengeluaranJaminan}', [ListJaminanPengeluaranController::class, 'show'])->name('administrasi.jaminan.pengeluaran.list.show');

    /// Menu Administrasi -> Jaminan Lelang -> Pengeluaran
    $route->get('/administrasi/jaminan/pengeluaran/create/get-komoditas', [PengeluaranJaminanController::class, 'get_komoditas'])->name('administrasi.jaminan.pengeluaran.get_komoditas');

    $route->get('/administrasi/jaminan/pengeluaran', [PengeluaranJaminanController::class, 'index'])->name('administrasi.jaminan.pengeluaran.index');
    $route->get('/administrasi/jaminan/pengeluaran/create', [PengeluaranJaminanController::class, 'create'])->name('administrasi.jaminan.pengeluaran.create');
    $route->post('/administrasi/jaminan/pengeluaran', [PengeluaranJaminanController::class, 'store'])->name('administrasi.jaminan.pengeluaran.store');
    $route->get('/administrasi/jaminan/pengeluaran/{pengeluaranJaminan}', [PengeluaranJaminanController::class, 'show'])->name('administrasi.jaminan.pengeluaran.show');
    $route->get('/administrasi/jaminan/pengeluaran/{pengeluaranJaminan}/edit', [PengeluaranJaminanController::class, 'edit'])->name('administrasi.jaminan.pengeluaran.edit');
    $route->put('/administrasi/jaminan/pengeluaran/{pengeluaranJaminan}', [PengeluaranJaminanController::class, 'update'])->name('administrasi.jaminan.pengeluaran.update');
    $route->delete('/administrasi/jaminan/pengeluaran/{pengeluaranJaminan}', [PengeluaranJaminanController::class, 'destroy'])->name('administrasi.jaminan.pengeluaran.destroy');

    // Menu Operational
    $route->get('/operational', OperationalPasarLelangController::class)->name('operational');

    /// Menu Operational -> Transaksi Lelang
    $route->get('/operational/lelang/transaksi', [OperationalTransaksiLelangController::class, 'index'])->name('operational.lelang.transaksi.index');
    $route->get('/operational/lelang/transaksi/{lelang}', [OperationalTransaksiLelangController::class, 'show'])->name('operational.lelang.transaksi.show');
    $route->put('/operational/lelang/transaksi/{lelang}', [OperationalTransaksiLelangController::class, 'update'])->name('operational.lelang.transaksi.update');
    $route->delete('/operational/lelang/transaksi/{lelang}', [OperationalTransaksiLelangController::class, 'destroy'])->name('operational.lelang.transaksi.destroy');

    /// Menu Operational -> Verifikasi Transaksi Lelang
    $route->get('/operational/lelang/verifikasi', [OperationalVerifikasiTransaksiLelangController::class, 'index'])->name('operational.lelang.verifikasi.index');
    $route->get('/operational/lelang/verifikasi/ditolak', [OperationalVerifikasiTransaksiLelangController::class, 'index_ditolak'])->name('operational.lelang.verifikasi.index_ditolak');
    $route->get('/operational/lelang/verifikasi/ditolak/{lelang}', [OperationalVerifikasiTransaksiLelangController::class, 'show_ditolak'])->name('operational.lelang.verifikasi.show_ditolak');
    $route->get('/operational/lelang/verifikasi/{lelang}', [OperationalVerifikasiTransaksiLelangController::class, 'show'])->name('operational.lelang.verifikasi.show');
    $route->put('/operational/lelang/verifikasi/{lelang}', [OperationalVerifikasiTransaksiLelangController::class, 'confirmation'])->name('operational.lelang.verifikasi.confirmation');
    $route->put('/operational/lelang/verifikasi/{lelang}/ulang', [OperationalVerifikasiTransaksiLelangController::class, 'confirmation_ulang'])->name('operational.lelang.verifikasi.confirmation_ulang');

    /// Menu Operational -> List Transaksi Lelang
    $route->get('/operational/lelang/list', [OperationalListTransaksiLelangController::class, 'index'])->name('operational.lelang.list.index');
    $route->get('/operational/lelang/list/{lelang}', [OperationalListTransaksiLelangController::class, 'show'])->name('operational.lelang.list.show');

    // Menu Laporan
    $route->get('/laporan', LaporanController::class)->name('laporan');
    $route->get('/laporan/api', [LaporanController::class, 'api'])->name('laporan.api');
    $route->get('/laporan/jaminan', LaporanJaminanController::class)->name('laporan.jaminan');
    $route->post('/laporan/jaminan', [LaporanJaminanController::class, 'generate'])->name('laporan.jaminan.generate');

    $route->get('/laporan/transaksi_lelang', LaporanTransaksiLelangController::class)->name('laporan.transaksi_lelang');
    $route->post('/laporan/transaksi_lelang', [LaporanTransaksiLelangController::class, 'generate'])->name('laporan.transaksi_lelang.generate');

    $route->get('/laporan/transaksi_bank', LaporanTransaksiBankController::class)->name('laporan.transaksi_bank');
    $route->post('/laporan/transaksi_bank', [LaporanTransaksiBankController::class, 'generate'])->name('laporan.transaksi_bank.generate');

    $route->get('/laporan/daftar_anggota', LaporanDaftarAnggotaController::class)->name('laporan.daftar_anggota');
    $route->post('/laporan/daftar_anggota', [LaporanDaftarAnggotaController::class, 'generate'])->name('laporan.daftar_anggota.generate');

    $route->get('/laporan/event_lelang', LaporanEventLelangController::class)->name('laporan.event_lelang');
    $route->get('/laporan/event_lelang/api', [LaporanEventLelangController::class, 'api'])->name('laporan.event_lelang.api');
    $route->post('/laporan/event_lelang', [LaporanEventLelangController::class, 'generate'])->name('laporan.event_lelang.generate');

    $route->get('/laporan/lelang', LaporanLelangController::class)->name('laporan.lelang');
    $route->post('/laporan/lelang', [LaporanLelangController::class, 'generate'])->name('laporan.lelang.generate');

    // Menu Lelang Online
    $route->get('/online', LelangOnlineController::class)->name('online');

    $route->get('/online/event/history', [EventLelangOnlineController::class, 'index_history'])->name('online.event.history');
    $route->get('/online/event/history/{lelang}', [EventLelangOnlineController::class, 'show_history'])->name('online.event.history.show');

    $route->get('/online/event', [EventLelangOnlineController::class, 'index'])->name('online.event');
    // $route->get('/online/event/{event}', [EventLelangOnlineController::class, 'show'])->name('online.event.show');
    // $route->get('/online/event/{event}/produk', [EventLelangOnlineController::class, 'produk'])->name('online.event.produk');
    $route->get('/online/event/{lelang}', [EventLelangOnlineController::class, 'produk_show'])->name('online.event.show');
    $route->get('/online/event/{lelang}/sesi', [EventLelangOnlineController::class, 'produk_sesi'])->name('online.event.sesi');
    $route->post('/online/event/{lelang}/sesi/api', [EventLelangOnlineController::class, 'online_list_lelang_sesi_api'])->name('online.event.sesi_api');

    $route->get('/online/event/{lelang}/anggota', [AnggotaEventLelangOnlineController::class, 'index'])->name('online.event.anggota');
    $route->get('/online/event/{lelang}/anggota/create', [AnggotaEventLelangOnlineController::class, 'create'])->name('online.event.anggota.create');
    $route->post('/online/event/{lelang}/anggota', [AnggotaEventLelangOnlineController::class, 'store'])->name('online.event.anggota.store');
    $route->get('/online/event/{lelang}/anggota/{anggota}', [AnggotaEventLelangOnlineController::class, 'show'])->name('online.event.anggota.show');
    $route->get('/online/event/{lelang}/anggota/{anggota}/edit', [AnggotaEventLelangOnlineController::class, 'edit'])->name('online.event.anggota.edit');
    $route->put('/online/event/{lelang}/anggota/{anggota}/', [AnggotaEventLelangOnlineController::class, 'update'])->name('online.event.anggota.update');
    $route->delete('/online/event/{lelang}/anggota/{anggota}', [AnggotaEventLelangOnlineController::class, 'destroy'])->name('online.event.anggota.destroy');

    $route->post('/online/list/{lelang}/doc/{file}', [EventLelangOnlineController::class, 'sesi_doc'])->name('online.event.produk.sesi_doc');

    $route->get('/online/list', [ListOnlineController::class, 'index'])->name('online.list');
    $route->get('/online/list/{masterSesiLelang}/{lelangSesiOnline}', [ListOnlineController::class, 'show'])->name('online.list.show');
    $route->post('/online/list/{masterSesiLelang}/{lelangSesiOnline}', [ListOnlineController::class, 'join'])->name('online.list.join');
    $route->get('/online/list/{masterSesiLelang}/{lelangSesiOnline}/{lelang}', [ListOnlineController::class, 'online_list_lelang'])->name('online.list.lelang');
    $route->get('/online/list/{masterSesiLelang}/{lelangSesiOnline}/{lelang}/sesi', [ListOnlineController::class, 'online_list_lelang_sesi'])->name('online.list.lelang_sesi');
    $route->post('/online/list/{masterSesiLelang}/{lelangSesiOnline}/{lelang}/sesi/api', [EventLelangOnlineController::class, 'online_list_lelang_sesi_api'])->name('online.list.lelang_sesi_api');
    $route->post('/online/list/{masterSesiLelang}/{lelangSesiOnline}/{lelang}/sesi/api', [EventLelangOnlineController::class, 'online_list_lelang_sesi_api_list'])->name('online.list.lelang_sesi_api_list');


    $route->get('/online/history', [HistoryOnlineController::class, 'index'])->name('online.history');
    $route->get('/online/history/{masterSesiLelang}/{lelangSesiOnline}', [HistoryOnlineController::class, 'show'])->name('online.history.show');

    $route->get('/offline/list', [ListOfflineController::class, 'index'])->name('offline.list');
    $route->get('/offline/list/{eventLelang}', [ListOfflineController::class, 'show'])->name('offline.list.show');
    $route->post('/offline/list/{eventLelang}', [ListOfflineController::class, 'join'])->name('offline.list.join');

    $route->get('/offline/list/{eventLelang}/{lelang}', [ListOfflineController::class, 'event_lelang'])->name('offline.list.lelang');
    $route->get('/offline/list/{eventLelang}/{lelang}/sesi', [ListOfflineController::class, 'sesi_lelang'])->name('offline.list.sesi_lelang');
    $route->post('/offline/list/{event}/{lelang}/sesi/api', [EventLelangProdukController::class, 'sesi_api'])->name('offline.list.sesi_lelang.api');

    $route->get('/offline/history', [HistoryOfflineController::class, 'index'])->name('offline.history');
    $route->get('/offline/history/{eventLelang}', [HistoryOfflineController::class, 'show'])->name('offline.history.show');

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

    $route->get('/offline/event/history', [EventLelangController::class, 'index_history'])->name('offline.event.history');
    $route->get('/offline/event/history/{event}', [EventLelangController::class, 'show_history'])->name('offline.event.history.show');

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
    $route->post('/offline/event/{event}/produk/{lelang}/doc/{file}', [EventLelangProdukController::class, 'sesi_doc'])->name('offline.event.produk.sesi_doc');
    $route->post('/offline/event/{event}/produk/{lelang}/sesi/api', [EventLelangProdukController::class, 'sesi_api'])->name('offline.event.produk.sesi.api');

    $route->get('/offline/event/{event}/anggota', [EventLelangAnggotaController::class, 'index'])->name('offline.event.anggota');
    $route->get('/offline/event/{event}/anggota-komoditi', [EventLelangAnggotaController::class, 'show_komoditi'])->name('offline.event.anggota.show_komoditi');
    $route->get('/offline/event/{event}/anggota-komoditi/cetak', [EventLelangAnggotaController::class, 'show_komoditi_cetak'])->name('offline.event.anggota.show_komoditi_cetak');
    $route->get('/offline/event/{event}/anggota/create', [EventLelangAnggotaController::class, 'create'])->name('offline.event.anggota.create');
    $route->post('/offline/event/{event}/anggota/{member}choose', [EventLelangAnggotaController::class, 'store_anggota'])->name('offline.event.anggota.store_anggota');
    $route->post('/offline/event/{event}/anggota', [EventLelangAnggotaController::class, 'store'])->name('offline.event.anggota.store');
    $route->get('/offline/event/{event}/anggota/{anggota}', [EventLelangAnggotaController::class, 'show'])->name('offline.event.anggota.show');
    $route->get('/offline/event/{event}/anggota/{anggota}/edit', [EventLelangAnggotaController::class, 'edit'])->name('offline.event.anggota.edit');
    $route->put('/offline/event/{event}/anggota/{anggota}/', [EventLelangAnggotaController::class, 'update'])->name('offline.event.anggota.update');
    $route->delete('/offline/event/{event}/anggota/{anggota}', [EventLelangAnggotaController::class, 'destroy'])->name('offline.event.anggota.destroy');

    $route->get('/blog', BlogController::class)->name('blog');

    $route->get('/blog/kategori', [BlogKategoriController::class, 'index'])->name('blog.kategori');
    $route->get('/blog/kategori/create', [BlogKategoriController::class, 'create'])->name('blog.kategori.create');
    $route->post('/blog/kategori', [BlogKategoriController::class, 'store'])->name('blog.kategori.store');
    $route->get('/blog/kategori/{blogKategori}', [BlogKategoriController::class, 'show'])->name('blog.kategori.show');
    $route->get('/blog/kategori/{blogKategori}/edit', [BlogKategoriController::class, 'edit'])->name('blog.kategori.edit');
    $route->put('/blog/kategori/{blogKategori}', [BlogKategoriController::class, 'update'])->name('blog.kategori.update');
    $route->delete('/blog/kategori/{blogKategori}', [BlogKategoriController::class, 'destroy'])->name('blog.kategori.destroy');

    $route->get('/blog/tag', [BlogTagController::class, 'index'])->name('blog.tag');
    $route->get('/blog/tag/create', [BlogTagController::class, 'create'])->name('blog.tag.create');
    $route->post('/blog/tag', [BlogTagController::class, 'store'])->name('blog.tag.store');
    $route->get('/blog/tag/{blogTag}', [BlogTagController::class, 'show'])->name('blog.tag.show');
    $route->get('/blog/tag/{blogTag}/edit', [BlogTagController::class, 'edit'])->name('blog.tag.edit');
    $route->put('/blog/tag/{blogTag}', [BlogTagController::class, 'update'])->name('blog.tag.update');
    $route->delete('/blog/tag/{blogTag}', [BlogTagController::class, 'destroy'])->name('blog.tag.destroy');

    $route->get('/blog/post/{blogPost}/meta', [BlogPostMetaController::class, 'index'])->name('blog.post.meta');
    $route->get('/blog/post/{blogPost}/meta/create', [BlogPostMetaController::class, 'create'])->name('blog.post.meta.create');
    $route->post('/blog/post/{blogPost}/meta', [BlogPostMetaController::class, 'store'])->name('blog.post.meta.store');
    $route->get('/blog/post/{blogPost}/meta/{blogPostMeta}', [BlogPostMetaController::class, 'show'])->name('blog.post.meta.show');
    $route->get('/blog/post/{blogPost}/meta/{blogPostMeta}/edit', [BlogPostMetaController::class, 'edit'])->name('blog.post.meta.edit');
    $route->put('/blog/post/{blogPost}/meta/{blogPostMeta}', [BlogPostMetaController::class, 'update'])->name('blog.post.meta.update');
    $route->delete('/blog/post/{blogPost}/meta/{blogPostMeta}', [BlogPostMetaController::class, 'destroy'])->name('blog.post.meta.destroy');

    $route->get('/blog/post', [BlogPostController::class, 'index'])->name('blog.post');
    $route->get('/blog/post/create', [BlogPostController::class, 'create'])->name('blog.post.create');
    $route->post('/blog/post', [BlogPostController::class, 'store'])->name('blog.post.store');
    $route->get('/blog/post/{blogPost}', [BlogPostController::class, 'show'])->name('blog.post.show');
    $route->get('/blog/post/{blogPost}/edit', [BlogPostController::class, 'edit'])->name('blog.post.edit');
    $route->put('/blog/post/{blogPost}/publish', [BlogPostController::class, 'publish'])->name('blog.post.publish');
    $route->put('/blog/post/{blogPost}', [BlogPostController::class, 'update'])->name('blog.post.update');
    $route->delete('/blog/post/{blogPost}', [BlogPostController::class, 'destroy'])->name('blog.post.destroy');

    // Menu Konfigurasi
    $route->get('/konfigurasi', KonfigurasiController::class)->name('konfigurasi');

    /// Role
    $route->get('/konfigurasi/role', [RoleController::class, 'index'])->name('konfigurasi.role');
    $route->get('/konfigurasi/role/create', [RoleController::class, 'create'])->name('konfigurasi.role.create');
    $route->post('/konfigurasi/role', [RoleController::class, 'store'])->name('konfigurasi.role.store');
    $route->get('/konfigurasi/role/{role}', [RoleController::class, 'show'])->name('konfigurasi.role.show');
    $route->get('/konfigurasi/role/{role}/edit', [RoleController::class, 'edit'])->name('konfigurasi.role.edit');
    $route->put('/konfigurasi/role/{role}', [RoleController::class, 'update'])->name('konfigurasi.role.update');
    $route->delete('/konfigurasi/role/{role}', [RoleController::class, 'destroy'])->name('konfigurasi.role.destroy');

    /// Admin
    $route->get('/konfigurasi/admin', [AdminController::class, 'index'])->name('konfigurasi.admin');
    $route->get('/konfigurasi/admin/create', [AdminController::class, 'create'])->name('konfigurasi.admin.create');
    $route->get('/konfigurasi/admin/{admin}', [AdminController::class, 'show'])->name('konfigurasi.admin.show');
    $route->put('/konfigurasi/admin/{member}/accepted', [AdminController::class, 'accepted'])->name('konfigurasi.admin.accepted');
    $route->put('/konfigurasi/admin/{admin}/aktif', [AdminController::class, 'aktif'])->name('konfigurasi.admin.status_aktif');
    $route->put('/konfigurasi/admin/{admin}/non_aktif', [AdminController::class, 'nonaktif'])->name('konfigurasi.admin.status_nonaktif');
    $route->delete('/konfigurasi/admin/{admin}', [AdminController::class, 'destroy'])->name('konfigurasi.admin.destroy');

    /// Mutu
    $route->get('/konfigurasi/mutu', [MutuController::class, 'index'])->name('konfigurasi.mutu');
    $route->get('/konfigurasi/mutu/create', [MutuController::class, 'create'])->name('konfigurasi.mutu.create');
    $route->post('/konfigurasi/mutu', [MutuController::class, 'store'])->name('konfigurasi.mutu.store');
    $route->get('/konfigurasi/mutu/{mutu}', [MutuController::class, 'show'])->name('konfigurasi.mutu.show');
    $route->get('/konfigurasi/mutu/{mutu}/edit', [MutuController::class, 'edit'])->name('konfigurasi.mutu.edit');
    $route->put('/konfigurasi/mutu/{mutu}', [MutuController::class, 'update'])->name('konfigurasi.mutu.update');
    $route->delete('/konfigurasi/mutu/{mutu}', [MutuController::class, 'destroy'])->name('konfigurasi.mutu.destroy');

    /// Jenis
    $route->get('/konfigurasi/jenis', JenisController::class)->name('konfigurasi.jenis');

    $route->get('/konfigurasi/jenis/harga', [JenisHargaController::class, 'index'])->name('konfigurasi.jenis.harga');
    $route->get('/konfigurasi/jenis/harga/create', [JenisHargaController::class, 'create'])->name('konfigurasi.jenis.harga.create');
    $route->post('/konfigurasi/jenis/harga', [JenisHargaController::class, 'store'])->name('konfigurasi.jenis.harga.store');
    $route->get('/konfigurasi/jenis/harga/{jenisHarga}', [JenisHargaController::class, 'show'])->name('konfigurasi.jenis.harga.show');
    $route->get('/konfigurasi/jenis/harga/{jenisHarga}/edit', [JenisHargaController::class, 'edit'])->name('konfigurasi.jenis.harga.edit');
    $route->put('/konfigurasi/jenis/harga/{jenisHarga}', [JenisHargaController::class, 'update'])->name('konfigurasi.jenis.harga.update');
    $route->delete('/konfigurasi/jenis/harga/{jenisHarga}', [JenisHargaController::class, 'destroy'])->name('konfigurasi.jenis.harga.destroy');

    $route->get('/konfigurasi/jenis/inisiasi', [JenisInisiasiController::class, 'index'])->name('konfigurasi.jenis.inisiasi');
    $route->get('/konfigurasi/jenis/inisiasi/create', [JenisInisiasiController::class, 'create'])->name('konfigurasi.jenis.inisiasi.create');
    $route->post('/konfigurasi/jenis/inisiasi', [JenisInisiasiController::class, 'store'])->name('konfigurasi.jenis.inisiasi.store');
    $route->get('/konfigurasi/jenis/inisiasi/{jenisInisiasi}', [JenisInisiasiController::class, 'show'])->name('konfigurasi.jenis.inisiasi.show');
    $route->get('/konfigurasi/jenis/inisiasi/{jenisInisiasi}/edit', [JenisInisiasiController::class, 'edit'])->name('konfigurasi.jenis.inisiasi.edit');
    $route->put('/konfigurasi/jenis/inisiasi/{jenisInisiasi}', [JenisInisiasiController::class, 'update'])->name('konfigurasi.jenis.inisiasi.update');
    $route->delete('/konfigurasi/jenis/inisiasi/{jenisInisiasi}', [JenisInisiasiController::class, 'destroy'])->name('konfigurasi.jenis.inisiasi.destroy');

    $route->get('/konfigurasi/jenis/perdagangan', [JenisPerdaganganController::class, 'index'])->name('konfigurasi.jenis.perdagangan');
    $route->get('/konfigurasi/jenis/perdagangan/create', [JenisPerdaganganController::class, 'create'])->name('konfigurasi.jenis.perdagangan.create');
    $route->post('/konfigurasi/jenis/perdagangan', [JenisPerdaganganController::class, 'store'])->name('konfigurasi.jenis.perdagangan.store');
    $route->get('/konfigurasi/jenis/perdagangan/{jenisPerdagangan}', [JenisPerdaganganController::class, 'show'])->name('konfigurasi.jenis.perdagangan.show');
    $route->get('/konfigurasi/jenis/perdagangan/{jenisPerdagangan}/edit', [JenisPerdaganganController::class, 'edit'])->name('konfigurasi.jenis.perdagangan.edit');
    $route->put('/konfigurasi/jenis/perdagangan/{jenisPerdagangan}', [JenisPerdaganganController::class, 'update'])->name('konfigurasi.jenis.perdagangan.update');
    $route->delete('/konfigurasi/jenis/perdagangan/{jenisPerdagangan}', [JenisPerdaganganController::class, 'destroy'])->name('konfigurasi.jenis.perdagangan.destroy');

    /// Area
    $route->get('/konfigurasi/area', AreaController::class)->name('konfigurasi.area');

    $route->get('/konfigurasi/area/provinsi', [ProvinsiController::class, 'index'])->name('konfigurasi.area.provinsi');
    $route->get('/konfigurasi/area/provinsi/create', [ProvinsiController::class, 'create'])->name('konfigurasi.area.provinsi.create');
    $route->post('/konfigurasi/area/provinsi', [ProvinsiController::class, 'store'])->name('konfigurasi.area.provinsi.store');
    $route->get('/konfigurasi/area/provinsi/{provinsi}', [ProvinsiController::class, 'show'])->name('konfigurasi.area.provinsi.show');
    $route->get('/konfigurasi/area/provinsi/{provinsi}/edit', [ProvinsiController::class, 'edit'])->name('konfigurasi.area.provinsi.edit');
    $route->put('/konfigurasi/area/provinsi/{provinsi}', [ProvinsiController::class, 'update'])->name('konfigurasi.area.provinsi.update');
    $route->delete('/konfigurasi/area/provinsi/{provinsi}', [ProvinsiController::class, 'destroy'])->name('konfigurasi.area.provinsi.destroy');

    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten', [KabupatenController::class, 'index'])->name('konfigurasi.area.provinsi.kabupaten');
    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/create', [KabupatenController::class, 'create'])->name('konfigurasi.area.provinsi.kabupaten.create');
    $route->post('/konfigurasi/area/provinsi/{provinsi}/kabupaten', [KabupatenController::class, 'store'])->name('konfigurasi.area.provinsi.kabupaten.store');
    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}', [KabupatenController::class, 'show'])->name('konfigurasi.area.provinsi.kabupaten.show');
    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/edit', [KabupatenController::class, 'edit'])->name('konfigurasi.area.provinsi.kabupaten.edit');
    $route->put('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}', [KabupatenController::class, 'update'])->name('konfigurasi.area.provinsi.kabupaten.update');
    $route->delete('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}', [KabupatenController::class, 'destroy'])->name('konfigurasi.area.provinsi.kabupaten.destroy');

    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan', [KecamatanController::class, 'index'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan');
    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/create', [KecamatanController::class, 'create'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.create');
    $route->post('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan', [KecamatanController::class, 'store'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.store');
    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}', [KecamatanController::class, 'show'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.show');
    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}/edit', [KecamatanController::class, 'edit'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.edit');
    $route->put('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}', [KecamatanController::class, 'update'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.update');
    $route->delete('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}', [KecamatanController::class, 'destroy'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.destroy');

    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}/desa', [DesaController::class, 'index'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.desa');
    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}/desa/create', [DesaController::class, 'create'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.desa.create');
    $route->post('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}/desa', [DesaController::class, 'store'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.desa.store');
    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}/desa/{desa}', [DesaController::class, 'show'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.desa.show');
    $route->get('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}/desa/{desa}/edit', [DesaController::class, 'edit'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.desa.edit');
    $route->put('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}/desa/{desa}', [DesaController::class, 'update'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.desa.update');
    $route->delete('/konfigurasi/area/provinsi/{provinsi}/kabupaten/{kabupaten}/kecamatan/{kecamatan}/desa/{desa}', [DesaController::class, 'destroy'])->name('konfigurasi.area.provinsi.kabupaten.kecamatan.desa.destroy');

    /// Status
    $route->get('/konfigurasi/status', StatusController::class)->name('konfigurasi.status');

    /// Status Member
    $route->get('/konfigurasi/status/member', [StatusMemberController::class, 'index'])->name('konfigurasi.status.member');
    $route->get('/konfigurasi/status/member/create', [StatusMemberController::class, 'create'])->name('konfigurasi.status.member.create');
    $route->post('/konfigurasi/status/member', [StatusMemberController::class, 'store'])->name('konfigurasi.status.member.store');
    $route->get('/konfigurasi/status/member/{statusMember}', [StatusMemberController::class, 'show'])->name('konfigurasi.status.member.show');
    $route->get('/konfigurasi/status/member/{statusMember}/edit', [StatusMemberController::class, 'edit'])->name('konfigurasi.status.member.edit');
    $route->put('/konfigurasi/status/member/{statusMember}', [StatusMemberController::class, 'update'])->name('konfigurasi.status.member.update');
    $route->delete('/konfigurasi/status/member/{statusMember}', [StatusMemberController::class, 'destroy'])->name('konfigurasi.status.member.destroy');

    /// Status Lelang
    $route->get('/konfigurasi/status/lelang', [StatusLelangController::class, 'index'])->name('konfigurasi.status.lelang');
    $route->get('/konfigurasi/status/lelang/create', [StatusLelangController::class, 'create'])->name('konfigurasi.status.lelang.create');
    $route->post('/konfigurasi/status/lelang', [StatusLelangController::class, 'store'])->name('konfigurasi.status.lelang.store');
    $route->get('/konfigurasi/status/lelang/{statusLelang}', [StatusLelangController::class, 'show'])->name('konfigurasi.status.lelang.show');
    $route->get('/konfigurasi/status/lelang/{statusLelang}/edit', [StatusLelangController::class, 'edit'])->name('konfigurasi.status.lelang.edit');
    $route->put('/konfigurasi/status/lelang/{statusLelang}', [StatusLelangController::class, 'update'])->name('konfigurasi.status.lelang.update');
    $route->delete('/konfigurasi/status/lelang/{statusLelang}', [StatusLelangController::class, 'destroy'])->name('konfigurasi.status.lelang.destroy');

    /// Rekening Pusat
    $route->get('/konfigurasi/rekening_pusat', [RekeningPusatController::class, 'index'])->name('konfigurasi.rekening_pusat');
    $route->get('/konfigurasi/rekening_pusat/create', [RekeningPusatController::class, 'create'])->name('konfigurasi.rekening_pusat.create');
    $route->post('/konfigurasi/rekening_pusat', [RekeningPusatController::class, 'store'])->name('konfigurasi.rekening_pusat.store');
    $route->get('/konfigurasi/rekening_pusat/{rekeningPusat}', [RekeningPusatController::class, 'show'])->name('konfigurasi.rekening_pusat.show');
    $route->get('/konfigurasi/rekening_pusat/{rekeningPusat}/edit', [RekeningPusatController::class, 'edit'])->name('konfigurasi.rekening_pusat.edit');
    $route->put('/konfigurasi/rekening_pusat/{rekeningPusat}', [RekeningPusatController::class, 'update'])->name('konfigurasi.rekening_pusat.update');
    $route->delete('/konfigurasi/rekening_pusat/{rekeningPusat}', [RekeningPusatController::class, 'destroy'])->name('konfigurasi.rekening_pusat.destroy');

    /// Dana Keuangan
    $route->get('/konfigurasi/dana_keuangan', [DanaKeuanganController::class, 'index'])->name('konfigurasi.dana_keuangan');
    $route->get('/konfigurasi/dana_keuangan/{danaKeuangan}', [DanaKeuanganController::class, 'show'])->name('konfigurasi.dana_keuangan.show');

    /// Status Event Lelang
    $route->get('/konfigurasi/status/event_lelang', [StatusEventLelangController::class, 'index'])->name('konfigurasi.status.event_lelang');
    $route->get('/konfigurasi/status/event_lelang/create', [StatusEventLelangController::class, 'create'])->name('konfigurasi.status.event_lelang.create');
    $route->post('/konfigurasi/status/event_lelang', [StatusEventLelangController::class, 'store'])->name('konfigurasi.status.event_lelang.store');
    $route->get('/konfigurasi/status/event_lelang/{statusEventLelang}', [StatusEventLelangController::class, 'show'])->name('konfigurasi.status.event_lelang.show');
    $route->get('/konfigurasi/status/event_lelang/{statusEventLelang}/edit', [StatusEventLelangController::class, 'edit'])->name('konfigurasi.status.event_lelang.edit');
    $route->put('/konfigurasi/status/event_lelang/{statusEventLelang}', [StatusEventLelangController::class, 'update'])->name('konfigurasi.status.event_lelang.update');
    $route->delete('/konfigurasi/status/event_lelang/{statusEventLelang}', [StatusEventLelangController::class, 'destroy'])->name('konfigurasi.status.event_lelang.destroy');

    /// Laporan
    $route->get('/konfigurasi/laporan', KonfigurasiLaporanController::class)->name('konfigurasi.laporan');

    $route->get('/konfigurasi/laporan/perjanjian_jual_beli', [KonfigurasiLaporanPerjanjianJualBeliController::class, 'index'])->name('konfigurasi.laporan.perjanjian_jual_beli');
    $route->get('/konfigurasi/laporan/perjanjian_jual_beli/create', [KonfigurasiLaporanPerjanjianJualBeliController::class, 'create'])->name('konfigurasi.laporan.perjanjian_jual_beli.create');
    $route->post('/konfigurasi/laporan/perjanjian_jual_beli', [KonfigurasiLaporanPerjanjianJualBeliController::class, 'store'])->name('konfigurasi.laporan.perjanjian_jual_beli.store');
    $route->get('/konfigurasi/laporan/perjanjian_jual_beli/{perjanjianJualBeliPasal}', [KonfigurasiLaporanPerjanjianJualBeliController::class, 'show'])->name('konfigurasi.laporan.perjanjian_jual_beli.show');
    $route->get('/konfigurasi/laporan/perjanjian_jual_beli/{perjanjianJualBeliPasal}/edit', [KonfigurasiLaporanPerjanjianJualBeliController::class, 'edit'])->name('konfigurasi.laporan.perjanjian_jual_beli.edit');
    $route->put('/konfigurasi/laporan/perjanjian_jual_beli/{perjanjianJualBeliPasal}', [KonfigurasiLaporanPerjanjianJualBeliController::class, 'update'])->name('konfigurasi.laporan.perjanjian_jual_beli.update');
    $route->delete('/konfigurasi/laporan/perjanjian_jual_beli/{perjanjianJualBeliPasal}', [KonfigurasiLaporanPerjanjianJualBeliController::class, 'destroy'])->name('konfigurasi.laporan.perjanjian_jual_beli.destroy');

    $route->get('/konfigurasi/aplikasi', KonfigurasiAplikasiController::class)->name('konfigurasi.aplikasi');

    // Aplikasi
    $route->get('/konfigurasi/aplikasi/aplikasi', [AplikasiController::class, 'index'])->name('konfigurasi.aplikasi.aplikasi');
    $route->get('/konfigurasi/aplikasi/aplikasi/create', [AplikasiController::class, 'create'])->name('konfigurasi.aplikasi.aplikasi.create');
    $route->post('/konfigurasi/aplikasi/aplikasi', [AplikasiController::class, 'store'])->name('konfigurasi.aplikasi.aplikasi.store');
    $route->get('/konfigurasi/aplikasi/aplikasi/{aplikasi}', [AplikasiController::class, 'show'])->name('konfigurasi.aplikasi.aplikasi.show');
    $route->get('/konfigurasi/aplikasi/aplikasi/{aplikasi}/edit', [AplikasiController::class, 'edit'])->name('konfigurasi.aplikasi.aplikasi.edit');
    $route->put('/konfigurasi/aplikasi/aplikasi/{aplikasi}', [AplikasiController::class, 'update'])->name('konfigurasi.aplikasi.aplikasi.update');
    $route->delete('/konfigurasi/aplikasi/aplikasi/{aplikasi}', [AplikasiController::class, 'destroy'])->name('konfigurasi.aplikasi.aplikasi.destroy');

    // Carousel
    $route->get('/konfigurasi/aplikasi/carousel', [CarouselController::class, 'index'])->name('konfigurasi.aplikasi.carousel');
    $route->get('/konfigurasi/aplikasi/carousel/create', [CarouselController::class, 'create'])->name('konfigurasi.aplikasi.carousel.create');
    $route->post('/konfigurasi/aplikasi/carousel', [CarouselController::class, 'store'])->name('konfigurasi.aplikasi.carousel.store');
    $route->get('/konfigurasi/aplikasi/carousel/{carousel}', [CarouselController::class, 'show'])->name('konfigurasi.aplikasi.carousel.show');
    $route->get('/konfigurasi/aplikasi/carousel/{carousel}/edit', [CarouselController::class, 'edit'])->name('konfigurasi.aplikasi.carousel.edit');
    $route->put('/konfigurasi/aplikasi/carousel/{carousel}', [CarouselController::class, 'update'])->name('konfigurasi.aplikasi.carousel.update');
    $route->delete('/konfigurasi/aplikasi/carousel/{carousel}', [CarouselController::class, 'destroy'])->name('konfigurasi.aplikasi.carousel.destroy');

    // Web Link
    $route->get('/konfigurasi/aplikasi/web_link', [WebLinkController::class, 'index'])->name('konfigurasi.aplikasi.web_link');
    $route->get('/konfigurasi/aplikasi/web_link/create', [WebLinkController::class, 'create'])->name('konfigurasi.aplikasi.web_link.create');
    $route->post('/konfigurasi/aplikasi/web_link', [WebLinkController::class, 'store'])->name('konfigurasi.aplikasi.web_link.store');
    $route->get('/konfigurasi/aplikasi/web_link/{webLink}', [WebLinkController::class, 'show'])->name('konfigurasi.aplikasi.web_link.show');
    $route->get('/konfigurasi/aplikasi/web_link/{webLink}/edit', [WebLinkController::class, 'edit'])->name('konfigurasi.aplikasi.web_link.edit');
    $route->put('/konfigurasi/aplikasi/web_link/{webLink}', [WebLinkController::class, 'update'])->name('konfigurasi.aplikasi.web_link.update');
    $route->delete('/konfigurasi/aplikasi/web_link/{webLink}', [WebLinkController::class, 'destroy'])->name('konfigurasi.aplikasi.web_link.destroy');

    // User

    // Saldo
    $route->get('/saldo', KontrakUserController::class)->name('saldo');
    $route->get('/saldo-saya', KontrakUserController::class)->name('saldo-saya');
    $route->get('/saldo-riwayat', KontrakUserController::class)->name('saldo-riwayat');

    // Kontrak
    $route->get('/kontrak', KontrakUserController::class)->name('kontrak');

    $route->get('/kontrak/pengajuan', [KontrakUserPengajuanController::class, 'index'])->name('kontrak.pengajuan');
    $route->get('/kontrak/pengajuan/create', [KontrakUserPengajuanController::class, 'create'])->name('kontrak.pengajuan.create');
    $route->post('/kontrak/pengajuan', [KontrakUserPengajuanController::class, 'store'])->name('kontrak.pengajuan.store');
    $route->get('/kontrak/pengajuan/{kontrak}', [KontrakUserPengajuanController::class, 'show'])->name('kontrak.pengajuan.show');
    $route->get('/kontrak/pengajuan/{kontrak}/edit', [KontrakUserPengajuanController::class, 'edit'])->name('kontrak.pengajuan.edit');
    $route->put('/kontrak/pengajuan/{kontrak}', [KontrakUserPengajuanController::class, 'update'])->name('kontrak.pengajuan.update');
    $route->delete('/kontrak/pengajuan/{kontrak}', [KontrakUserPengajuanController::class, 'destroy'])->name('kontrak.pengajuan.destroy');

    $route->get('/kontrak/list', [KontrakUserListController::class, 'index'])->name('kontrak.list');
    $route->get('/kontrak/list/{kontrak}', [KontrakUserListController::class, 'show'])->name('kontrak.list.show');

    // Lelang
    $route->get('/lelang', LelangUserController::class)->name('lelang');

    $route->get('/lelang/pengajuan', [LelangUserPengajuanController::class, 'index'])->name('lelang.pengajuan');
    $route->get('/lelang/pengajuan/create', [LelangUserPengajuanController::class, 'create'])->name('lelang.pengajuan.create');
    $route->post('/lelang/pengajuan', [LelangUserPengajuanController::class, 'store'])->name('lelang.pengajuan.store');
    $route->get('/lelang/pengajuan/{lelang}', [LelangUserPengajuanController::class, 'show'])->name('lelang.pengajuan.show');
    $route->get('/lelang/pengajuan/{lelang}/edit', [LelangUserPengajuanController::class, 'edit'])->name('lelang.pengajuan.edit');
    $route->put('/lelang/pengajuan/{lelang}', [LelangUserPengajuanController::class, 'update'])->name('lelang.pengajuan.update');
    $route->delete('/lelang/pengajuan/{lelang}', [LelangUserPengajuanController::class, 'destroy'])->name('lelang.pengajuan.destroy');

    $route->get('/lelang/pengajuan/{lelang}/file', [LelangUserDokumenController::class, 'index'])->name('lelang.pengajuan.file');
    $route->get('/lelang/pengajuan/{lelang}/file/create', [LelangUserDokumenController::class, 'create'])->name('lelang.pengajuan.file.create');
    $route->post('/lelang/pengajuan/{lelang}/file', [LelangUserDokumenController::class, 'store'])->name('lelang.pengajuan.file.store');
    $route->get('/lelang/pengajuan/{lelang}/file/{file}', [LelangUserDokumenController::class, 'show'])->name('lelang.pengajuan.file.show');
    $route->get('/lelang/pengajuan/{lelang}/file/{file}/edit', [LelangUserDokumenController::class, 'edit'])->name('lelang.pengajuan.file.edit');
    $route->put('/lelang/pengajuan/{lelang}/file/{file}', [LelangUserDokumenController::class, 'update'])->name('lelang.pengajuan.file.update');
    $route->delete('/lelang/pengajuan/{lelang}/file/{file}', [LelangUserDokumenController::class, 'destroy'])->name('lelang.pengajuan.file.destroy');

    $route->get('/lelang/list', [LelangUserListController::class, 'index'])->name('lelang.list');
    $route->get('/lelang/list/{lelang}', [LelangUserListController::class, 'show'])->name('lelang.list.show');

    $route->get('/lelang/transaksi', [LelangUserTransaksiController::class, 'index'])->name('lelang.transaksi');
    $route->get('/lelang/transaksi/now', [LelangUserTransaksiController::class, 'index_now'])->name('lelang.transaksi_now');
    $route->get('/lelang/transaksi/{lelang}', [LelangUserTransaksiController::class, 'show'])->name('lelang.transaksi.show');
    $route->put('/lelang/transaksi/{lelang}', [LelangUserTransaksiController::class, 'update'])->name('lelang.transaksi.update');

    $route->put('/lelang/transaksi/{lelang}/komoditas-masuk/{komoditasMasuk}', [LelangUserTransaksiController::class, 'update_komoditas_masuk'])->name('lelang.transaksi.komoditas.masuk.update');
    $route->put('/lelang/transaksi/{lelang}/komoditas-keluar/{komoditasKeluar}', [LelangUserTransaksiController::class, 'update_komoditas_keluar'])->name('lelang.transaksi.komoditas.keluar.update');
    $route->put('/lelang/transaksi/{lelang}/keuangan-masuk/{keuanganMasuk}', [LelangUserTransaksiController::class, 'update_keuangan_masuk'])->name('lelang.transaksi.keuangan.masuk.update');
    $route->put('/lelang/transaksi/{lelang}/rating', [LelangUserTransaksiController::class, 'update_rating'])->name('lelang.transaksi.rating.update');

    // End User
});

Route::get('/artikel', [ArtikelController::class, 'index'])->name('welcome.artikel');
Route::get('/artikel/{post}', [ArtikelController::class, 'show'])->name('welcome.artikel.post');
Route::get('/artikel/tag/{blogTag}', [ArtikelController::class, 'tag'])->name('welcome.artikel.tag');
Route::get('/artikel/user/{admin}', [ArtikelController::class, 'user'])->name('welcome.artikel.user');

Route::get('/welcome-lelang', [WelcomeLelangController::class, 'index'])->name('welcome.lelang');

Route::get('/welcome-lelang/online/{lelang}', [WelcomeLelangController::class, 'online_lelang'])->name('welcome.online_lelang');
Route::get('/welcome-lelang/online/{lelang}/sesi', [WelcomeLelangController::class, 'online_lelang_sesi'])->name('welcome.online_lelang_sesi');
Route::post('/welcome-lelang/online/{lelang}/sesi/api', [EventLelangOnlineController::class, 'online_list_lelang_sesi_api_list'])->name('welcome.online_lelang_sesi_api');

Route::get('/welcome-lelang/event-offline/{event}', [WelcomeLelangController::class, 'event_offline'])->name('welcome.event_offline');
Route::get('/welcome-lelang/event-offline/{event}/lelang/{lelang}', [WelcomeLelangController::class, 'event_offline_lelang'])->name('welcome.event_offline_lelang');
Route::get('/welcome-lelang/event-offline/{event}/lelang/{lelang}/sesi', [WelcomeLelangController::class, 'event_offline_lelang_sesi'])->name('welcome.event_offline_lelang_sesi');
Route::post('/welcome-lelang/event-offline/{event}/lelang/{lelang}/sesi/api', [EventLelangProdukController::class, 'sesi_api'])->name('welcome.event_offline_lelang_sesi_api');
