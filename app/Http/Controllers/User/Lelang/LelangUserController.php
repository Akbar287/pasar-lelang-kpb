<?php

namespace App\Http\Controllers\User\Lelang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LelangUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Pangajuan Lelang",
                "icon" => "th",
                "url" => route('lelang.pengajuan'),
                "color" => "primary"
            ],
            [
                "nama" => "List Lelang",
                "icon" => "book",
                "url" => route('lelang.list'),
                "color" => "success"
            ]
        ];
        return view('user/lelang/index', compact('allMenu'));
    }
}
