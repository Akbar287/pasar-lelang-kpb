<?php

namespace App\Http\Controllers\MasterData\Lainnya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaturanHariLiburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master_data/master_lainnya/hari_libur/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master_data/master_lainnya/hari_libur/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('master_data/master_lainnya/hari_libur/show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('master_data/master_lainnya/hari_libur/edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function hariLiburData()
    {
        return [];
    }
}
