<?php

namespace App\Http\Controllers\Konfigurasi\Aplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebLinkRequest;
use App\Models\Aplikasi;
use App\Models\WebLink;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WebLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WebLink::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.aplikasi.web_link.show', $row->web_links_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('konfigurasi.aplikasi.web_link.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aplikasi = Aplikasi::get();
        return view('konfigurasi.aplikasi.web_link.create', compact('aplikasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebLinkRequest $webLinkRequest)
    {
        $aplikasi = Aplikasi::where('aplikasi_id', $webLinkRequest->aplikasi_id);
        $webLink = WebLink::create($this->web_linkData());

        return redirect('/konfigurasi/aplikasi/web_link/' . $webLink->web_link_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Web link telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(WebLink $webLink)
    {
        return view('konfigurasi.aplikasi.web_link.show', compact('webLink'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebLink $webLink)
    {
        $aplikasi = Aplikasi::get();
        return view('konfigurasi.aplikasi.web_link.edit', compact('webLink', 'aplikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebLinkRequest $webLinkRequest, WebLink $webLink)
    {
        $webLink->update($this->web_linkData());

        return redirect('/konfigurasi/aplikasi/web_link/' . $webLink->web_link_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Web link telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebLink $webLink)
    {
        $webLink->delete();

        return redirect('/konfigurasi/aplikasi/web_link')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Web link telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function web_linkData()
    {
        return [
            'aplikasi_id' => request('aplikasi_id'),
            'nama_web' => request('nama_web'),
            'link' => request('link')
        ];
    }
}
