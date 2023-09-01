<?php

namespace App\Http\Controllers\LelangOnline;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LelangOnlineController extends Controller
{
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Event Lelang Online",
                "icon" => "th",
                "url" => route('online.event'),
                "color" => "primary"
            ],
        ];
        return view('lelang_online/index', compact('allMenu'));
    }
}
