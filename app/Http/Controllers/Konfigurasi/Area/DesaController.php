<?php

namespace App\Http\Controllers\Konfigurasi\Area;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan)
    {
        if ($request->ajax()) {
            $data = $kecamatan->desa()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('member', function ($row) {
                    $actionBtn = $row->area_member()->count();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.area.provinsi.kabupaten.kecamatan.desa.show', [$row->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->provinsi_id, $row->kecamatan()->first()->kabupaten()->first()->kabupaten_id, $row->kecamatan()->first()->kecamatan_id, $row->desa_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('konfigurasi/area/desa/index', compact('provinsi', 'kabupaten', 'kecamatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan)
    {
        return view('konfigurasi/area/desa/create', compact('provinsi', 'kabupaten', 'kecamatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan)
    {
        $request->validate([
            'nama_desa' => ['required']
        ]);

        $desa = $kecamatan->desa()->create($this->desaData());

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id . '/kabupaten/' . $kabupaten->kabupaten_id . '/kecamatan/' . $kecamatan->kecamatan_id . '/desa/' . $desa->desa_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Desa telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan, Desa $desa)
    {
        return view('konfigurasi/area/desa/show', compact('provinsi', 'kabupaten', 'kecamatan', 'desa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan, Desa $desa)
    {
        return view('konfigurasi/area/desa/edit', compact('provinsi', 'kabupaten', 'kecamatan', 'desa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan, Desa $desa)
    {
        $request->validate([
            'nama_desa' => ['required']
        ]);

        $desa->update($this->desaData());

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id . '/kabupaten/' . $kabupaten->kabupaten_id . '/kecamatan/' . $kecamatan->kecamatan_id . '/desa/' . $desa->desa_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Desa telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan, Desa $desa)
    {
        $desa->delete();

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id . '/kabupaten/' . $kabupaten->kabupaten_id . '/kecamatan/' . $kecamatan->kecamatan_id . '/desa')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Desa telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function desaData()
    {
        return [
            'nama_desa' => request('nama_desa'),
        ];
    }

    public function api_desa(Request $request)
    {
        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        $total = $request->has('kecamatanId') ? Desa::where('kecamatan_id', $request->get('kecamatanId'))->count() : Desa::count();

        $page_count = ceil($total / $size);

        $data = $request->has('kecamatanId')
            ? DB::Table('desa')
            ->where('kecamatan_id', $request->get('kecamatanId'))
            ->orderBy('nama_desa', 'asc')
            ->forPage($page, $size)
            ->get()
            : DB::Table('desa')
            ->orderBy('nama_desa', 'asc')
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);
            return response()->json([
                'data' => $paginator,
                'status' => 'success',
                'message' => 'desa has been catched'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'status' => 'success',
                'message' => 'desa has been catched'
            ], 200);
        }
    }

    public function set_area()
    {
        $cekProvinsi = Provinsi::count();
        $cekKabupaten = Kabupaten::count();
        $cekKecamatan = Kecamatan::count();
        $cekDesa = Desa::count();

        if ($cekProvinsi == 0) {
            // Call API to Get Provinsi
            (array) $temp = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi')->json()['provinsi'];

            $provinsiData = [];
            for ($i = 0; $i < count($temp); $i++) {
                $provinsiData[] = $temp[$i];
            }

            foreach ($provinsiData as $pd) {
                $provinsi = new Provinsi();
                $provinsi->nama_provinsi = $pd['nama'];
                $provinsi->save();

                // Kabupaten
                if ($cekKabupaten == 0) {

                    // Get Kabupaten By API Call
                    (array) $tempKab = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' . $pd['id'])->json()['kota_kabupaten'];

                    $kabupatenData = [];
                    for ($i = 0; $i < count($tempKab); $i++) {
                        $kabupatenData[] = $tempKab[$i];
                    }

                    if (count($kabupatenData) > 0) {
                        foreach ($kabupatenData as $kd) {
                            $kabupaten = $provinsi->kabupaten()->create([
                                "nama_kabupaten" => $kd['nama']
                            ]);

                            //Kecamatan
                            if ($cekKecamatan == 0) {

                                // Call API to Get Kecamatan Data
                                (array) $tempKec = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=' . $kd['id'])->json()['kecamatan'];

                                $kecamatanData = [];
                                for ($i = 0; $i < count($tempKec); $i++) {
                                    $kecamatanData[] = $tempKec[$i];
                                }

                                if (count($kecamatanData) > 0) {
                                    foreach ($kecamatanData as $ked) {
                                        $kecamatan = $kabupaten->kecamatan()->create([
                                            "nama_kecamatan" => $ked['nama']
                                        ]);


                                        // Desa
                                        if ($cekDesa == 0) {
                                            // Call API to Get Desa Data
                                            (array) $tempDes = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=' . $ked['id'])->json()['kelurahan'];

                                            $desaData = [];
                                            for ($i = 0; $i < count($tempDes); $i++) {
                                                $desaData[] = $tempDes[$i];
                                            }


                                            if (count($desaData) > 0) {
                                                foreach ($desaData as $dd) {
                                                    $desa = $kecamatan->desa()->create([
                                                        'nama_desa' => $dd['nama']
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
