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
                "url" => route('administrasi.jaminan.penerimaan.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Verifikasi Penerimaan Jaminan",
                "icon" => "filter",
                "url" => route('administrasi.jaminan.penerimaan.verifikasi.index'),
                "color" => "secondary"
            ],
            [
                "nama" => "List Penerimaan Jaminan",
                "icon" => "tint",
                "url" => route('administrasi.jaminan.penerimaan.list.index'),
                "color" => "success"
            ],
            [
                "nama" => "Pengeluaran Jaminan Lelang",
                "icon" => "th",
                "url" => route('administrasi.jaminan.pengeluaran.index'),
                "color" => "danger"
            ],
            [
                "nama" => "Verifikasi Pengeluaran Jaminan",
                "icon" => "filter",
                "url" => route('administrasi.jaminan.pengeluaran.verifikasi.index'),
                "color" => "warning"
            ],
            [
                "nama" => "List Pengeluaran Jaminan",
                "icon" => "tint",
                "url" => route('administrasi.jaminan.pengeluaran.list.index'),
                "color" => "info"
            ]
        ];
        return view('administrasi/jaminan/index', compact('allMenu'));
    }
}
