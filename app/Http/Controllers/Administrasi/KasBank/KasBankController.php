<?php

namespace App\Http\Controllers\Administrasi\KasBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KasBankController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Penerimaan Kas dan Bank",
                "icon" => "th",
                "url" => route('administrasi.kas_bank.penerimaan.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Verifikasi Kas dan Bank",
                "icon" => "filter",
                "url" => route('administrasi.kas_bank.verifikasi.index'),
                "color" => "secondary"
            ],
            [
                "nama" => "Daftar Transaksi Kas dan Bank",
                "icon" => "tint",
                "url" => route('administrasi.kas_bank.list.index'),
                "color" => "success"
            ]
        ];
        return view('administrasi/kas_bank/index', compact('allMenu'));
    }
}
