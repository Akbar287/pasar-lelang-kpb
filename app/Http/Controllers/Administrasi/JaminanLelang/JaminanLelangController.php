<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JaminanLelangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Penerimaan Jaminan Lelang",
                "icon" => "th",
                "url" => route('anggota.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Verifikasi Penerimaan Jaminan",
                "icon" => "filter",
                "url" => route('menu.procurement'),
                "color" => "secondary"
            ],
            [
                "nama" => "Daftar Penerimaan Jaminan",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ],
            [
                "nama" => "Pengeluaran Jaminan Lelang",
                "icon" => "th",
                "url" => route('anggota.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Verifikasi Pengeluaran Jaminan",
                "icon" => "filter",
                "url" => route('menu.procurement'),
                "color" => "secondary"
            ],
            [
                "nama" => "Daftar Pengeluaran Jaminan",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ],
        ];
        return view('administrasi/jaminan_lelang/index', compact('allMenu'));
    }
}
