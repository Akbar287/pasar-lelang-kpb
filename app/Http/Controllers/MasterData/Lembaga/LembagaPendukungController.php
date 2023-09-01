<?php

namespace App\Http\Controllers\MasterData\Lembaga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LembagaPendukungController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Bank",
                "icon" => "th",
                "url" => route('master.lembaga.bank'),
                "color" => "primary"
            ],
            [
                "nama" => "Gudang",
                "icon" => "filter",
                "url" => route('master.lembaga.gudang'),
                "color" => "secondary"
            ]
        ];
        return view('master_data/lembaga_pendukung/index', compact('allMenu'));
    }
}
