<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperationalPasarLelangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Transaksi Lelang",
                "icon" => "th",
                "url" => route('operational.lelang.transaksi.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Verifikasi Transaksi Lelang",
                "icon" => "filter",
                "url" => route('operational.lelang.verifikasi.index'),
                "color" => "secondary"
            ],
            [
                "nama" => "Transaksi Lelang Selesai",
                "icon" => "tint",
                "url" => route('operational.lelang.list.index'),
                "color" => "success"
            ]
        ];
        return view('operational/index', compact('allMenu'));
    }
}
