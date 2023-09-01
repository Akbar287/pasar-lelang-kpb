<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function provinsi()
    {
        $provinsi = Provinsi::get();
        return response()->json([
            "data" => $provinsi,
            'message' => 'data has been fetched',
            'status' => 200
        ], 200);
    }

    public function kabupaten(Provinsi $provinsi)
    {
        $kabupaten = $provinsi->kabupaten()->get();
        return response()->json([
            "data" => $kabupaten,
            'message' => 'data has been fetched',
            'status' => 200
        ], 200);
    }

    public function kecamatan(Kabupaten $kabupaten)
    {
        $kecamatan = $kabupaten->kecamatan()->get();
        return response()->json([
            "data" => $kecamatan,
            'message' => 'data has been fetched',
            'status' => 200
        ], 200);
    }

    public function desa(Kecamatan $kecamatan)
    {
        $desa = $kecamatan->desa()->get();
        return response()->json([
            "data" => $desa,
            'message' => 'data has been fetched',
            'status' => 200
        ], 200);
    }
}
