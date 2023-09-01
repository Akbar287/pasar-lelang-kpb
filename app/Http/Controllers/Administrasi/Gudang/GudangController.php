<?php

namespace App\Http\Controllers\Administrasi\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Penerimaan Barang",
                "icon" => "th",
                "url" => route('administrasi.gudang.penerimaan.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Verifikasi Penerimaan Barang",
                "icon" => "filter",
                "url" => route('administrasi.gudang.verifikasi.index'),
                "color" => "secondary"
            ],
            [
                "nama" => "Daftar Transaksi Penerimaan Barang",
                "icon" => "tint",
                "url" => route('administrasi.gudang.list.index'),
                "color" => "success"
            ]
        ];
        return view('administrasi/gudang/index', compact('allMenu'));
    }
}
