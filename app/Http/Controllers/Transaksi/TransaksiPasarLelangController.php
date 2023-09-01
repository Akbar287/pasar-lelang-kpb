<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransaksiPasarLelangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Lelang Baru",
                "icon" => "th",
                "url" => route('transaksi.lelang_baru'),
                "color" => "primary"
            ],
            [
                "nama" => "Verifikasi Lelang",
                "icon" => "filter",
                "url" => route('transaksi.verifikasi'),
                "color" => "secondary"
            ],
            [
                "nama" => "Daftar Lelang",
                "icon" => "upload",
                "url" => route('transaksi.list'),
                "color" => "danger"
            ]
        ];
        return view('transaksi_pasar_lelang/index', compact('allMenu'));
    }
}
