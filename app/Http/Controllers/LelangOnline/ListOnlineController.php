<?php

namespace App\Http\Controllers\LelangOnline;

use App\Http\Controllers\Controller;
use App\Models\JenisDokumenProduk;
use App\Models\Lelang;
use App\Models\LelangSesiOnline;
use App\Models\MasterSesiLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ListOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = LelangSesiOnline::distinct('master_sesi_lelang.master_sesi_lelang_id')->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')->where('lelang_sesi_online.tanggal', ">=", Carbon::now())->get();
        if ($request->ajax()) {
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
                ->addColumn('sesi', function ($row) {
                    $actionBtn = $row->sesi . '(' . $row->jam_mulai . '-' . $row->jam_berakhir . ')';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('online.list.show', [$row->master_sesi_lelang_id, $row->lelang_sesi_online_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('lelang_online/list/index');
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
                ->addColumn('harga_awal', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->lelang()->first()->harga_awal ?? 0, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('kelipatan', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->lelang()->first()->kelipatan_penawaran ?? 0, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('online.list.lelang', [$row->lelang()->first()->lelang_sesi_online()->first()->master_sesi_lelang()->first()->master_sesi_lelang_id, $row->lelang()->first()->lelang_sesi_online()->first()->lelang_sesi_online_id, $row->lelang()->first()->lelang_id]) . '" class="edit btn btn-success btn-sm">Lelang</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('lelang_online/list/show', compact('masterSesiLelang', 'lelangSesiOnline'));
    }

    public function join(MasterSesiLelang $masterSesiLelang, LelangSesiOnline $lelangSesiOnline)
    {
        if (is_null($masterSesiLelang->peserta_lelang()->where('tanggal', $lelangSesiOnline->tanggal)->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first())) {
            $masterSesiLelang->peserta_lelang()->create([
                'tanggal' => $lelangSesiOnline->tanggal,
                'informasi_akun_id' => Auth::user()->informasi_akun_id,
                'kode_peserta_lelang' => $this->rekomendasiKodeAnggota($lelangSesiOnline)
            ]);
        }

        return redirect('/online/list/' . $masterSesiLelang->master_sesi_lelang_id . '/' . $lelangSesiOnline->lelang_sesi_online_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Anda telah bergabung di Sesi Lelang ini.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function rekomendasiKodeAnggota($lelangSesiOnline)
    {
        $temp = $lelangSesiOnline->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelangSesiOnline->tanggal)->orderBy('kode_peserta_lelang', 'desc')->first();

        return is_null($temp) ? 1 : intval($temp->kode_peserta_lelang) + 1;
    }

    public function online_list_lelang(MasterSesiLelang $masterSesiLelang, LelangSesiOnline $lelangSesiOnline, Lelang $lelang)
    {
        $jenisDokumen = JenisDokumenProduk::get();
        return view('lelang_online/list/show_lelang', compact('masterSesiLelang', 'lelangSesiOnline', 'lelang', 'jenisDokumen'));
    }

    public function online_list_lelang_sesi(MasterSesiLelang $masterSesiLelang, LelangSesiOnline $lelangSesiOnline, Lelang $lelang)
    {
        return view('lelang_online/list/show_lelang_sesi', compact('masterSesiLelang', 'lelangSesiOnline', 'lelang'));
    }
}
