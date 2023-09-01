<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Requests\LelangRequest;
use App\Models\EventLelang;
use App\Models\JenisHarga;
use App\Models\JenisInisiasi;
use App\Models\JenisPerdagangan;
use App\Models\Kontrak;
use App\Models\Lelang;
use App\Models\MasterSesiLelang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DaftarLelangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Lelang::get();
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
                ->addColumn('tanggal', function ($row) {
                    return is_null($row->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline ? $row->lelang_sesi_online()->first()->tanggal . ' (' . $row->lelang_sesi_online()->first()->master_sesi_lelang()->first()->sesi . ')' : ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline ? $row->event_lelang()->first()->tanggal_lelang : $row->event_lelang()->first()->tanggal_lelang));
                })
                ->addColumn('jam', function ($row) {
                    return is_null($row->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline ? $row->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_mulai . '-' . $row->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_berakhir : ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline ? $row->event_lelang()->first()->jam_mulai . '-' . $row->event_lelang()->first()->jam_selesai : $row->event_lelang()->first()->jam_mulai . '-' . $row->event_lelang()->first()->jam_selesai));
                })
                ->addColumn('kontrak', function ($row) {
                    $actionBtn = $row->kontrak()->first()->kontrak_kode;
                    return $actionBtn;
                })
                ->addColumn('harga_awal', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->harga_awal, 2, ",", ".");
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai' ? '<div class="badge badge-success">' . $row->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status . '</div>' : '<div class="badge badge-primary">' . $row->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status . '</div>';
                    return $actionBtn;
                })
                ->addColumn('jenis', function ($row) {
                    $actionBtn = is_null($row->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-success">Online</div>' : ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-info">Hybrid</div>' : '<div class="badge badge-primary">Offline</div>'));
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('transaksi.lelang_list.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status', 'jenis', 'tanggal', 'jam'])
                ->make(true);
        }
        return view('transaksi_pasar_lelang/daftar_lelang/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lelang $lelang)
    {
        $jenisHarga = JenisHarga::get();
        $masterSesiLelang = MasterSesiLelang::where('is_aktif', true)->get();
        $eventLelang = EventLelang::where('is_open', true)->get();
        return view('transaksi_pasar_lelang/daftar_lelang/show', compact('lelang', 'jenisHarga', 'masterSesiLelang', 'eventLelang'));
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
        return view('transaksi_pasar_lelang/daftar_lelang/edit', compact('jenisPerdagangan', 'jenisInisiasi', 'kontrak', 'jenisHarga', 'lelang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LelangRequest $lelangRequest, Lelang $lelang)
    {
        $lelang->update($this->lelangData());

        return redirect('/transaksi/list_lelang/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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

    public function penawaranPadaHargaSatuan()
    {
        $data = JenisHarga::where('nama_jenis_harga', 'Penawaran Pada Harga Satuan')->first();

        return response()->json([
            'message' => 'id has been collected',
            'status' => 200,
            'data' => $data->jenis_harga_id
        ], 200);
    }
}
