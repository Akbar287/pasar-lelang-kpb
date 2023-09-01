<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Requests\LelangRequest;
use App\Models\InformasiAkun;
use App\Models\JenisHarga;
use App\Models\JenisInisiasi;
use App\Models\JenisPerdagangan;
use App\Models\Kontrak;
use App\Models\Lelang;
use App\Models\StatusLelang;
use App\Models\StatusMember;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LelangBaruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = StatusLelang::where('nama_status', 'Daftar')->first();
            $data = Lelang::where('status_lelang_pivot.status_lelang_id', $status->status_lelang_id)->where('status_lelang_pivot.is_aktif', true)->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    if (!is_null($row->kontrak()->first()->informasi_akun()->first()->lembaga()->first())) {
                        $actionBtn = $row->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                    } else {
                        $actionBtn = $row->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('kontrak', function ($row) {
                    $actionBtn = $row->kontrak()->first()->kontrak_kode;
                    return $actionBtn;
                })
                ->addColumn('harga_awal', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->harga_awal, 2, ",", ".");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('transaksi.lelang_baru.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi_pasar_lelang/lelang_baru/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisPerdagangan = JenisPerdagangan::get();
        $jenisInisiasi = JenisInisiasi::get();
        $informasiAkun = StatusMember::where('nama_status', 'Aktif')->first()->member()->get();
        $jenisHarga = JenisHarga::get();
        return view('transaksi_pasar_lelang/lelang_baru/create', compact('jenisPerdagangan', 'jenisInisiasi', 'jenisHarga', 'informasiAkun'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LelangRequest $lelangRequest)
    {
        $kontrak = Kontrak::where('kontrak_id', $lelangRequest->kontrak_id)->first();
        $status = StatusLelang::where('nama_status', 'Daftar')->first();
        $lelang = $kontrak->lelang()->create($this->lelangData());

        $lelang->status_lelang_pivot()->create($this->status_lelang_pivot($status->status_lelang_id));

        return redirect('/transaksi/lelang_baru/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di Aktifkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lelang $lelang)
    {
        $jenisHarga = JenisHarga::get();
        return view('transaksi_pasar_lelang/lelang_baru/show', compact('lelang', 'jenisHarga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lelang $lelang)
    {
        $jenisPerdagangan = JenisPerdagangan::get();
        $jenisInisiasi = JenisInisiasi::get();
        $kontrak = Kontrak::where('informasi_akun_id', $lelang->kontrak()->first()->informasi_akun_id)->get();
        $jenisHarga = JenisHarga::get();
        return view('transaksi_pasar_lelang/lelang_baru/edit', compact('jenisPerdagangan', 'jenisInisiasi', 'kontrak', 'jenisHarga', 'lelang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LelangRequest $lelangRequest, Lelang $lelang)
    {
        $lelang->update($this->lelangData());

        return redirect('/transaksi/lelang_baru/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lelang $lelang)
    {
        $lelang->delete();

        return redirect('/transaksi/lelang_baru')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function lelangData()
    {
        return [
            'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
            'jenis_inisiasi_id' => request('jenis_inisiasi_id'),
            'jenis_harga_id' => request('jenis_harga_id'),
            'kontrak_id' => request('kontrak_id'),
            'nomor_lelang' => request('nomor_lelang'),
            'judul' => request('judul'),
            'asal_komoditas' => request('asal_komoditas'),
            'spesifikasi_produk' => request('spesifikasi_produk'),
            'kuantitas' => str_replace(',', '', request('kuantitas')),
            'kemasan' => request('kemasan'),
            'lokasi_penyerahan' => request('lokasi_penyerahan'),
            'harga_awal' => str_replace(',', '', request('harga_awal')),
            'kelipatan_penawaran' => str_replace(',', '', request('kelipatan_penawaran')),
            'harga_beli_sekarang' => is_null(request('harga_beli_sekarang_check')) ? null : (request('harga_beli_sekarang') != null ? str_replace(',', '', request('harga_beli_sekarang')) : null),
        ];
    }

    public function status_lelang_pivot($statusId)
    {
        return [
            'status_lelang_id' => $statusId,
            'is_aktif' => true
        ];
    }

    public function option(Request $request)
    {
        if ($request->jenis == 'informasi_akun') {
            $informasiAkun = InformasiAkun::where('informasi_akun_id', $request->informasi_akun_id)->first();

            return response()->json([
                'status' => 'success',
                'data' => $informasiAkun->kontrak()->select('kontrak.kontrak_id')->addSelect('kontrak.kontrak_kode')->addSelect('kontrak.simbol')->addSelect('komoditas.nama_komoditas')->addSelect('kontrak.minimum_transaksi')->addSelect('jenis_perdagangan.nama_perdagangan')->addSelect('kontrak.maksimum_transaksi')->addSelect('mutu.nama_mutu')->addSelect('komoditas.satuan_ukuran')->leftJoin('mutu', 'mutu.mutu_id', 'kontrak.mutu_id')->leftJoin('jenis_perdagangan', 'jenis_perdagangan.jenis_perdagangan_id', 'kontrak.jenis_perdagangan_id')->leftJoin('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')->where('kontrak.is_aktif', true)->where('kontrak.is_verified', true)->addSelect('komoditas.komoditas_id')->where('kontrak.is_status_verified', true)->get(),
                'message' => 'data komoditas has been reached'
            ], 200);
            exit;
        } else if ($request->jenis == 'kontrak_detail_komoditas') {
            $kontrak = Kontrak::where('kontrak_id', $request->kontrak_id)->first();
            if (is_null($kontrak)) {
                return response()->json([
                    'status' => 'failed',
                    'data' => [],
                    'message' => 'no data can be reached'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'data' => [
                        "komoditas_id" => $kontrak->komoditas()->first()->komoditas_id,
                        "kontrak_id" => $kontrak->kontrak_id,
                        "kontrak_kode" => $kontrak->kontrak_kode,
                        "maksimum_transaksi" => $kontrak->maksimum_transaksi,
                        "minimum_transaksi" => $kontrak->minimum_transaksi,
                        "nama_komoditas" => $kontrak->komoditas()->first()->nama_komoditas,
                        "nama_mutu" => $kontrak->mutu()->first()->nama_mutu,
                        "nama_perdagangan" => $kontrak->jenis_perdagangan()->first()->nama_perdagangan,
                        "satuan_ukuran" => $kontrak->komoditas()->first()->satuan_ukuran,
                        "simbol" => $kontrak->simbol,
                    ],
                    'message' => 'no data can be reached'
                ], 200);
            }
            exit;
        } else {
            return response()->json([
                'status' => 'failed',
                'data' => [],
                'message' => 'no data can be reached'
            ], 200);
            exit;
        }
    }
}
