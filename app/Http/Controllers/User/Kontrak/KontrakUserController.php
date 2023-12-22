<?php

namespace App\Http\Controllers\User\Kontrak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KontrakUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Pangajuan Kontrak",
                "icon" => "th",
                "url" => route('kontrak.pengajuan'),
                "color" => "primary"
            ],
            [
                "nama" => "List Kontrak",
                "icon" => "book",
                "url" => route('kontrak.list'),
                "color" => "success"
            ]
        ];
        return view('user/kontrak_pasar_lelang/index', compact('allMenu'));
    }
}
