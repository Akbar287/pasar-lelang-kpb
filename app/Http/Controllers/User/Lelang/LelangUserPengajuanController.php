<?php

namespace App\Http\Controllers\User\Lelang;

use App\Http\Controllers\Controller;
use App\Http\Requests\LelangRequest;
use App\Models\JenisHarga;
use App\Models\JenisInisiasi;
use App\Models\JenisPerdagangan;
use App\Models\Kontrak;
use App\Models\Lelang;
use App\Models\StatusKontrak;
use App\Models\StatusLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class LelangUserPengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = StatusLelang::select('status_lelang_id')->whereIn('nama_status', ['Draft', 'Daftar'])->get();

            $data = Auth::user()->informasi_akun()->first()->kontrak()->select('lelang.kuantitas')->addSelect('lelang.nomor_lelang')->addSelect('kontrak.kontrak_kode')->addSelect('lelang.judul')->addSelect('lelang.harga_awal')->addSelect('lelang.kelipatan_penawaran')->addSelect('lelang.created_at')->addSelect('lelang.lelang_id')->addSelect('status_lelang_pivot.status_lelang_id')->addSelect('status_lelang.nama_status')->join('lelang', 'lelang.kontrak_id', 'kontrak.kontrak_id')->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->leftJoin('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')->where('status_lelang_pivot.is_aktif', true)->whereNull('lelang.deleted_at')->whereIn('status_lelang_pivot.status_lelang_id', $status)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kuantitas', function ($row) {
                    $actionBtn = number_format($row->kuantitas, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('harga_awal', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->harga_awal, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('kelipatan_penawaran', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->kelipatan_penawaran, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->nama_status == 'Daftar' ? '<div class="badge badge-info">Daftar</div>' : '<div class="badge badge-info">Draft</div>';
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $actionBtn = is_null($row->created_at) ? "Tidak ada Data" : $row->created_at->toDateTimeString();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('lelang.pengajuan.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('user/lelang/pengajuan/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisPerdagangan = JenisPerdagangan::select('jenis_perdagangan_id')->addSelect('nama_perdagangan')->where('is_aktif', true)->get();
        $jenisInisiasi = JenisInisiasi::select('jenis_inisiasi_id')->addSelect('nama_inisiasi')->where('is_aktif', true)->get();
        $status = StatusKontrak::where('nama_status', 'Aktif')->first();
        $kontrak = Auth::user()->informasi_akun()->first()->kontrak()->where('status_kontrak_id', $status->status_kontrak_id)->get();
        $jenisHarga = JenisHarga::get();
        return view('user/lelang/pengajuan/create', compact('jenisPerdagangan', 'jenisInisiasi', 'kontrak', 'jenisHarga'));
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

        return redirect('/lelang/pengajuan/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di buat.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lelang $lelang)
    {
        $jenisHarga = JenisHarga::get();
        return view('user/lelang/pengajuan/show', compact('lelang', 'jenisHarga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lelang $lelang)
    {
        $jenisPerdagangan = JenisPerdagangan::select('jenis_perdagangan_id')->addSelect('nama_perdagangan')->where('is_aktif', true)->get();
        $jenisInisiasi = JenisInisiasi::select('jenis_inisiasi_id')->addSelect('nama_inisiasi')->where('is_aktif', true)->get();
        $status = StatusKontrak::where('nama_status', 'Aktif')->first();
        $kontrak = Auth::user()->informasi_akun()->first()->kontrak()->where('status_kontrak_id', $status->status_kontrak_id)->get();
        $jenisHarga = JenisHarga::get();
        return view('user/lelang/pengajuan/edit', compact('lelang', 'jenisPerdagangan', 'jenisInisiasi', 'kontrak', 'jenisHarga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LelangRequest $lelangRequest, Lelang $lelang)
    {
        $lelang->update($this->lelangData());

        return redirect('/lelang/pengajuan/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lelang $lelang)
    {
        $lelang->delete();

        return redirect('/lelang/pengajuan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function lelangData()
    {
        return [
            'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
            'jenis_inisiasi_id' => request('jenis_inisiasi_id'),
            'jenis_harga_id' => request('jenis_harga_id'),
            'kontrak_id' => request('kontrak_id'),
            'nomor_lelang' => $this->generateNomorLelang(),
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

    public function generateNomorLelang()
    {
        $kontrak = Kontrak::where('kontrak_id', request('kontrak_id'))->first();
        $temp = 'LELANG-' . strtoupper($kontrak->jenis_perdagangan()->first()->nama_perdagangan) . '-' . strtoupper($kontrak->komoditas()->first()->nama_komoditas) . '-';
        $i = 1;
        $check = true;
        do {
            $db = Lelang::where('nomor_lelang', $temp . $i)->count();
            if ($db == 0) {
                $check = false;
            } else {
                $i++;
            }
        } while ($check);

        return $temp . $i;
    }
}
