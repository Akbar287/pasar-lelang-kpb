<?php

namespace App\Http\Controllers\Welcome;

use App\Http\Controllers\Controller;
use App\Models\EventLelang;
use App\Models\JenisDokumenProduk;
use App\Models\Lelang;
use App\Models\LelangSesiOnline;
use App\Models\MasterSesiLelang;
use Carbon\Carbon;

class WelcomeLelangController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $masterSesiLelang = MasterSesiLelang::orderBy('jam_mulai', 'asc')->get();
        $lso = LelangSesiOnline::where('tanggal', now()->format('Y-m-d'))->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')->orderBy('master_sesi_lelang.jam_mulai', 'asc')->paginate(12);
        $eventLelang = EventLelang::where('tanggal_lelang', '>=', Carbon::now()->format('Y-m-d'))->get();

        return view('welcome.lelang.index', compact('masterSesiLelang', 'lso', 'eventLelang'));
    }

    public function online_lelang(Lelang $lelang)
    {
        $jenisDokumen = JenisDokumenProduk::get();
        return view('welcome.lelang.lelang_online', compact('lelang', 'jenisDokumen'));
    }

    public function online_lelang_sesi(Lelang $lelang)
    {
        $jenisDokumen = JenisDokumenProduk::get();
        return view('welcome.lelang.lelang_online_sesi', compact('lelang', 'jenisDokumen'));
    }

    public function event_offline(EventLelang $event)
    {
        return view('welcome.lelang.event_offline', compact('event'));
    }

    public function event_offline_lelang(EventLelang $event, Lelang $lelang)
    {
        $jenisDokumen = JenisDokumenProduk::get();
        return view('welcome.lelang.event_offline_produk', compact('event', 'lelang', 'jenisDokumen'));
    }

    public function event_offline_lelang_sesi(EventLelang $event, Lelang $lelang)
    {
        $jenisDokumen = JenisDokumenProduk::get();
        return view('welcome.lelang.event_offline_produk_sesi', compact('event', 'lelang', 'jenisDokumen'));
    }
}
