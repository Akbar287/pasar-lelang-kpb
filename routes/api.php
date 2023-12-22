<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Administrasi\JaminanLelang\PenerimaanJaminanController;
use App\Http\Controllers\Administrasi\KasBank\ListKasBankController;
use App\Http\Controllers\Administrasi\KasBank\PenerimaanKasBankController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Konfigurasi\Jenis\JenisHargaController;
use App\Http\Controllers\Konfigurasi\Jenis\JenisInisiasiController;
use App\Http\Controllers\Konfigurasi\Area\DesaController;
use App\Http\Controllers\Konfigurasi\Area\KabupatenController;
use App\Http\Controllers\Konfigurasi\Area\KecamatanController;
use App\Http\Controllers\Konfigurasi\Area\ProvinsiController;
use App\Http\Controllers\Konfigurasi\Jenis\JenisPerdaganganController;
use App\Http\Controllers\Konfigurasi\MutuController;
use App\Http\Controllers\Konfigurasi\PenyelenggaraPasarLelangController;
use App\Http\Controllers\LelangOffline\EventLelangAnggotaController;
use App\Http\Controllers\LelangOffline\EventLelangController;
use App\Http\Controllers\LelangOnline\EventLelangOnlineController;
use App\Http\Controllers\MasterData\Anggota\DokumenMemberController;
use App\Http\Controllers\MasterData\Anggota\RekeningBankController;
use App\Http\Controllers\MasterData\Kontrak\ListKontrakController;
use App\Http\Controllers\MasterData\Kontrak\PengaturanKontrakController;
use App\Http\Controllers\MasterData\Lainnya\KomoditasController;
use App\Http\Controllers\MasterData\Lembaga\BankController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Transaksi\DaftarLelangController;
use App\Http\Controllers\Transaksi\DokumenProdukLelangController;
use App\Http\Controllers\Transaksi\LelangBaruController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Area
Route::prefix('v1')->group(function ($route) {
    $route->post('login', [AuthController::class, 'login'])->name('api.login');
    $route->post('register', [AuthController::class, 'register'])->name('api.register');

    $route->get('/set_area', [DesaController::class, 'set_area'])->name('api.set_area');
    $route->get('/provinsi', [ProvinsiController::class, 'api_provinsi'])->name('api.provinsi'); //Provinsi
    $route->get('/kabupaten', [KabupatenController::class, 'api_kabupaten'])->name('api.kabupaten'); //Kabupaten
    $route->get('/kecamatan', [KecamatanController::class, 'api_kecamatan'])->name('api.kecamatan'); //Kecamatan
    $route->get('/desa', [DesaController::class, 'api_desa'])->name('api.desa'); //Desa
    $route->get('/jenis_dokumen', [DokumenMemberController::class, 'api_dokumen'])->name('api.dokumen_jenis');
    $route->get('/status-lelang', [LelangBaruController::class, 'getStatusLelang'])->name('api.getStatusLelang');
    $route->get('/status-lelang/{statusLelang}', [LelangBaruController::class, 'getStatusLelangById'])->name('api.getStatusLelangById');

    $route->get('/lelang/list/guest', [DaftarLelangController::class, 'api_get_guest'])->name('api.list_lelang_index.guest');

    $route->get('/dokumen/{dokumenProduk}', [HomeController::class, 'get_dokumen_lelang'])->name('api.dokumen_lelang');

    // Sesi Lelang
    $route->get('/sesi-online', [EventLelangOnlineController::class, 'api_lelang_online'])->name('api.sesi-online');
    $route->get('/sesi-online/{lelang}', [EventLelangOnlineController::class, 'api_lelang_online_detail'])->name('api.sesi-online-detail');

    //Sesi Offline / hybrid
    $route->get('/sesi-event', [EventLelangController::class, 'api_sesi_event'])->name('api.sesi-event');
    $route->get('/sesi-event/{eventLelang}', [EventLelangController::class, 'api_sesi_event_detail'])->name('api.sesi-event-detail');
    $route->get('/sesi-event/{eventLelang}/produk/{lelang}', [EventLelangController::class, 'api_sesi_event_detail_lelang'])->name('api.sesi-event-detail-lelang');
    $route->get('/sesi-event/{eventLelang}/id', [EventLelangController::class, 'api_sesi_event_detail_lelang_id'])->name('api.sesi-event-detail-lelang-id');


    // Jenis Harga
    $route->get('/jenis-harga', [JenisHargaController::class, 'api_jenis_harga'])->name('api.jenis_harga');

    // Mutu
    $route->get('/mutu', [MutuController::class, 'api_get_mutu'])->name('api.get_mutu');

    // Komoditas
    $route->get('/komoditas', [KomoditasController::class, 'api_komoditas'])->name('api.komoditas');

    // Jenis Perdagangan
    $route->get('/jenis-perdagangan', [JenisPerdaganganController::class, 'api_jenis_perdagangan'])->name('api.jenis_perdagangan');

    // Jenis Inisiasi
    $route->get('/jenis-inisiasi', [JenisInisiasiController::class, 'api_jenis_inisiasi'])->name('api.jenis_inisiasi');

    // Jneis Transaksi
    $route->get('/jenis-transaksi', [PenerimaanKasBankController::class, 'api_jenis_transaksi'])->name('api.jenis_transaksi');
});

Route::middleware('jwt')->prefix('v1')->group(function ($route) {

    // AuthController
    $route->post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    $route->post('/refresh', [AuthController::class, 'refreshToken'])->name('api.refresh');
    $route->post('/register_keuangan', [AuthController::class, 'register_keuangan'])->name('api.register.keuangan');
    $route->post('/register_dokumen', [AuthController::class, 'register_dokumen'])->name('api.register.dokumen');

    // User Profil
    $route->get('/profile', [AuthController::class, 'profile'])->name('api.profile');
    $route->get('/activity-log', [Activit::class, 'profile'])->name('api.profile');

    //Notifikasi
    $route->get('/notifikasi', [NotifikasiController::class, 'api_notifikasi'])->name('api.notifikasi');

    // Keuangan
    $route->get('/bank', [BankController::class, 'api_get_bank'])->name('api.bank');
    $route->get('/kurs-mata-uang', [RekeningBankController::class, 'api_kurs_mata_uang'])->name('api.kurs_mata_uang');

    // Rekening Bank
    $route->get('/rekening-bank', [RekeningBankController::class, 'api_rekening_bank'])->name('api.rekening_bank');
    $route->post('/rekening-bank', [RekeningBankController::class, 'api_create_rekening_bank'])->name('api.rekening_bank_create');
    $route->get('/rekening-bank/{rekeningBank}', [RekeningBankController::class, 'api_show_rekening_bank'])->name('api.rekening_bank_show');
    $route->put('/rekening-bank/{rekeningBank}', [RekeningBankController::class, 'api_update_rekening_bank'])->name('api.rekening_bank_update');
    $route->delete('/rekening-bank/{rekeningBank}', [RekeningBankController::class, 'api_delete_rekening_bank'])->name('api.rekening_bank_delete');

    // Kontrak Pengajuan
    $route->get('/kontrak/pengajuan', [PengaturanKontrakController::class, 'api_index'])->name('api.pengajuan_kontrak_index');
    $route->post('/kontrak/pengajuan', [PengaturanKontrakController::class, 'api_create'])->name('api.pengajuan_kontrak_create');
    $route->get('/kontrak/pengajuan/{kontrak}', [PengaturanKontrakController::class, 'api_show'])->name('api.pengajuan_kontrak_show');
    $route->put('/kontrak/pengajuan/{kontrak}', [PengaturanKontrakController::class, 'api_update'])->name('api.pengajuan_kontrak_update');
    $route->delete('/kontrak/pengajuan/{kontrak}', [PengaturanKontrakController::class, 'api_delete'])->name('api.pengajuan_kontrak_delete');

    // Kontrak List
    $route->get('/kontrak/list/all', [ListKontrakController::class, 'api_index_all'])->name('api.list_kontrak_index_all');
    $route->get('/kontrak/list/{kontrak}', [ListKontrakController::class, 'api_show'])->name('api.list_kontrak_show');

    // Dokumen Lelang Pengajuan
    $route->get('/lelang/dokumen/{lelang}/dokumen', [DokumenProdukLelangController::class, 'api_index'])->name('api.pengajuan_lelang_index');
    $route->post('/lelang/dokumen/{lelang}/dokumen', [DokumenProdukLelangController::class, 'api_store'])->name('api.pengajuan_lelang_store');
    $route->get('/lelang/dokumen/{lelang}/dokumen/{file}', [DokumenProdukLelangController::class, 'api_show'])->name('api.pengajuan_lelang_show');
    $route->put('/lelang/dokumen/{lelang}/dokumen/{file}', [DokumenProdukLelangController::class, 'api_update'])->name('api.pengajuan_lelang_update');
    $route->delete('/lelang/dokumen/{lelang}/dokumen/{file}', [DokumenProdukLelangController::class, 'api_destroy'])->name('api.pengajuan_lelang_destroy');

    // Lelang Pengajuan
    $route->get('/lelang/pengajuan', [LelangBaruController::class, 'api_index'])->name('api.pengajuan_lelang_index');
    $route->post('/lelang/pengajuan', [LelangBaruController::class, 'api_store'])->name('api.pengajuan_lelang_store');
    $route->get('/lelang/pengajuan/{lelang}', [LelangBaruController::class, 'api_show'])->name('api.pengajuan_lelang_show');
    $route->put('/lelang/pengajuan/{lelang}', [LelangBaruController::class, 'api_update'])->name('api.pengajuan_lelang_update');
    $route->delete('/lelang/pengajuan/{lelang}', [LelangBaruController::class, 'api_delete'])->name('api.pengajuan_lelang_delete');

    // Lelang List
    $route->get('/lelang/list', [DaftarLelangController::class, 'api_index'])->name('api.list_lelang_index');
    $route->get('/lelang/list/all', [DaftarLelangController::class, 'api_get_all'])->name('api.list_lelang_index.all');

    $route->get('/lelang/list/{lelang}', [DaftarLelangController::class, 'api_show'])->name('api.list_lelang_show');
    $route->get('/lelang/{event}/bid/{lelang}', [DaftarLelangController::class, 'api_bid'])->name('api.list_lelang_bid');

    // Cek User tersebut terdaftar sebagai peserta atau tidak di sesi lelang itu
    $route->get('/lelang/{lelang}', [DaftarLelangController::class, 'api_checking_user_id_regist'])->name('api.api_checking_user');

    // PenyelenggaraPasarLelang
    $route->get('/penyelenggara-pasar-lelang', [PenyelenggaraPasarLelangController::class, 'api_penyelenggara'])->name('api.penyelenggara');

    // Activity Log
    $route->get('/activity', [ActivityLogController::class, 'activityLog'])->name('api.activity_log');

    // Keuangan
    $route->get('/keuangan', [PenerimaanKasBankController::class, 'api_get_keuangan_history'])->name('api.get_keuangan_history');
    $route->get('/deposit', [PenerimaanKasBankController::class, 'api_get_deposit_history'])->name('api.get_deposit_history');
    $route->post('/deposit', [PenerimaanKasBankController::class, 'api_deposit_dana'])->name('api.deposit');
    $route->get('/kurs-mata-uang', [PenerimaanKasBankController::class, 'api_kurs_mata_uang'])->name('api.kurs_mata_uang');
    $route->get('/deposit-dokumen', [PenerimaanKasBankController::class, 'api_get_deposit_dokumen_history'])->name('api.get_deposit_dokumen_history');
    $route->post('/deposit-dokumen', [PenerimaanKasBankController::class, 'api_deposit_dokumen_dana'])->name('api.deposit_dokumen');
    $route->get('/withdraw', [PenerimaanKasBankController::class, 'api_get_withdraw_history'])->name('api.get_withdraw_history');
    $route->post('/withdraw', [PenerimaanKasBankController::class, 'api_withdraw_dana'])->name('api.withdraw');
    $route->get('/jaminan-saldo', [PenerimaanJaminanController::class, 'getJaminanByUser'])->name('api.getJaminanByUser');
    $route->get('/rekening-saldo', [ListKasBankController::class, 'getKeuanganSaldo'])->name('api.getKeuanganSaldo');

    $route->get('/riwayat-sesi-lelang', [DaftarLelangController::class, 'getStatusLelangRiwayat'])->name('api.getStatusLelangRiwayat');

    // Join Lelang
    $route->post('/join-lelang-offline', [EventLelangAnggotaController::class, 'joinEventLelangOffline'])->name('api.joinEventLelangOffline');
    $route->post('/join-lelang-online', [DaftarLelangController::class, 'joinEventLelangOnline'])->name('api.joinEventLelangOnline');
});
