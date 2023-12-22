<?php

namespace App\Http\Controllers\LelangOnline;

use App\Http\Controllers\Controller;
use App\Models\LelangSesiOnline;
use App\Models\MasterSesiLelang;
use App\Models\PesertaLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HistoryOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $waktuMulai = $request->has('waktu_mulai') ? Carbon::createFromFormat('Y-m-d', $request->waktu_mulai) : Carbon::now()->subDays(7);
        $waktuSelesai = $request->has('waktu_selesai') ? Carbon::createFromFormat('Y-m-d', $request->waktu_selesai) : Carbon::now();
        if ($waktuMulai->gt($waktuSelesai)) {
            $temp = $waktuMulai;
            $waktuMulai = $waktuSelesai;
            $waktuSelesai = $temp;
        }
        $waktuMulai = $waktuMulai->format('Y-m-d');
        $waktuSelesai = $waktuSelesai->format('Y-m-d');

        if ($request->ajax()) {
            $data = LelangSesiOnline::distinct('master_sesi_lelang.master_sesi_lelang_id')->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')->whereBetween('lelang_sesi_online.tanggal', [$waktuMulai, $waktuSelesai])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('anggota', function ($row) {
                    $actionBtn = $row->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $row->tanggal)->count();
                    return $actionBtn;
                })
                ->addColumn('produk', function ($row) {
                    $actionBtn = $row->master_sesi_lelang()->first()->lelang_sesi_online()->where('lelang_sesi_online.tanggal', $row->tanggal)->count();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('online.history.show', [$row->lelang()->first()->lelang_sesi_online()->first()->master_sesi_lelang()->first()->master_sesi_lelang_id, $row->lelang()->first()->lelang_sesi_online()->first()->lelang_sesi_online_id, $row->lelang()->first()->lelang_id]) . '" class="edit btn btn-success btn-sm">Lelang</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('lelang_online/history/index', compact('waktuMulai', 'waktuSelesai'));
    }

    public function show(Request $request, MasterSesiLelang $masterSesiLelang, LelangSesiOnline $lelangSesiOnline)
    {
        if ($request->ajax()) {
            $data = $masterSesiLelang->lelang_sesi_online()->where('tanggal', $lelangSesiOnline->tanggal)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('penjual', function ($row) {
                    $actionBtn = $row->lelang()->first()->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('gambar', function ($row) {
                    $img = is_null($row->lelang()->first()->dokumen_produk()->where('is_gambar_utama', true)->first()) ? null : $row->lelang()->first()->dokumen_produk()->where('is_gambar_utama', true)->first();

                    return '<img src="' . asset('storage/produk/' . (is_null($img) ? 'default.png' : $img->nama_file)) . '" alt="' . (is_null($img) ? 'default.png' : $img->nama_dokumen) . '" style="width: 75px;height: 75px;" class="img img-thumbnail" />';
                })
                ->addColumn('nama_produk', function ($row) {
                    return $row->lelang()->first()->judul ?? "-";
                })
                ->addColumn('kuantitas', function ($row) {
                    return number_format($row->lelang()->first()->kuantitas ?? 0, 0, ".", ",");
                })
                ->addColumn('kode_peserta', function ($row) {
                    return is_null($row->lelang()->first()->peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()) ? '-' : $row->lelang()->first()->peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()->peserta_lelang()->first()->kode_peserta_lelang;
                })
                ->addColumn('harga_awal', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->lelang()->first()->harga_awal ?? 0, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('kelipatan', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->lelang()->first()->kelipatan_penawaran ?? 0, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('harga_pemenang', function ($row) {
                    $actionBtn = 'Rp. ' . number_format(is_null($row->lelang()->first()->peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()) ? 0 : $row->lelang()->first()->peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()->harga_ajuan, 0, ".", ",");
                    return $actionBtn;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('lelang_online/history/show', compact('masterSesiLelang', 'lelangSesiOnline'));
    }
}
