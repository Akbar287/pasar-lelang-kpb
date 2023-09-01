<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\EventLelang;
use App\Models\JenisHarga;
use App\Models\JenisVerifikasi;
use App\Models\Lelang;
use App\Models\MasterSesiLelang;
use App\Models\StatusLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class VerifikasiLelangController extends Controller
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
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai' ? '<div class="badge badge-success">' . $row->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status . '</div>' : '<div class="badge badge-primary">' . $row->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status . '</div>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('transaksi.verifikasi_lelang.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('transaksi_pasar_lelang/verifikasi_lelang/index');
    }

    public function show(Lelang $lelang)
    {
        $jenisHarga = JenisHarga::get();
        $masterSesiLelang = MasterSesiLelang::where('is_aktif', true)->get();
        $eventLelangOffline = EventLelang::where('is_open', true)->where('is_online', false)->get();
        $eventLelangHybrid = EventLelang::where('is_open', true)->where('is_online', true)->get();
        return view('transaksi_pasar_lelang/verifikasi_lelang/show', compact('lelang', 'jenisHarga', 'masterSesiLelang', 'eventLelangOffline', 'eventLelangHybrid'));
    }

    public function show_ditolak(Lelang $lelang)
    {
        $jenisHarga = JenisHarga::get();
        $masterSesiLelang = MasterSesiLelang::where('is_aktif', true)->get();
        $eventLelangOffline = EventLelang::where('is_open', true)->where('is_online', false)->get();
        $eventLelangHybrid = EventLelang::where('is_open', true)->where('is_online', true)->get();
        return view('transaksi_pasar_lelang/verifikasi_lelang/show_ditolak', compact('lelang', 'jenisHarga', 'masterSesiLelang', 'eventLelangOffline', 'eventLelangHybrid'));
    }

    public function index_ditolak(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusLelang::where('nama_status', 'Tolak')->first()->lelang()->get();
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
                    $actionBtn = '<a href="' . route('transaksi.verifikasi_lelang.show.ditolak', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi_pasar_lelang/verifikasi_lelang/index_ditolak');
    }

    public function cancel_ditolak(Request $request, Lelang $lelang)
    {
        $informasi_akun = $lelang->kontrak()->first()->informasi_akun()->first();
        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Produk Lelang')->first();

        $verified_log =  $informasi_akun->verified_log()->create([
            'admin_id' => Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id,
            'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
            'is_agree' => true,
            "tanggal_verifikasi" => date('Y-m-d H:i:s'),
            'keterangan' => $request->keterangan
        ]);

        $lelang_verified_sesi = $lelang->lelang_verified_sesi()->create([
            'verified_log_id' => $verified_log->verified_log_id,
        ]);

        $lelang->status_lelang_pivot()->delete();
        $status = StatusLelang::where('nama_status', 'Daftar')->first();
        $lelang->status_lelang_pivot()->create([
            'status_lelang_id' => $status->status_lelang_id,
            'is_aktif' => true
        ]);

        return redirect('/transaksi/verifikasi_lelang/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di verifikasi Ulang.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function confirmation(Request $request, Lelang $lelang)
    {

        $informasi_akun = $lelang->kontrak()->first()->informasi_akun()->first();
        $statusLelangVerifikasi = StatusLelang::where('nama_status', 'Verifikasi')->first();
        $statusLelangAktif = StatusLelang::where('nama_status', 'Aktif')->first();
        $statusLelangTolak = StatusLelang::where('nama_status', 'Tolak')->first();
        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Produk Lelang')->first();

        // Validation
        $request->validate([
            'konfirmasi' => ['required'],
        ]);

        if ($request->konfirmasi == 'true') {
            $request->validate([
                'jenis_penyelenggaraan' => ['required'],
            ]);

            if ($request->jenis_penyelenggaraan == 'online') {
                $request->validate([
                    'master_sesi_lelang_id' => ['required'],
                    'tanggal' => ['required'],
                ]);
            } else {
                $request->validate([
                    'event_lelang' => ['required'],
                ]);
            }
        }
        // End Validation

        $verified_log =  $informasi_akun->verified_log()->create([
            'admin_id' => Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id,
            'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
            'is_agree' => true,
            "tanggal_verifikasi" => date('Y-m-d H:i:s'),
            'keterangan' => $request->keterangan
        ]);

        $lelang_verified_sesi = $lelang->lelang_verified_sesi()->create([
            'verified_log_id' => $verified_log->verified_log_id,
        ]);

        foreach ($lelang->status_lelang_pivot()->get() as $ls) {
            $ls->update([
                'is_aktif' => false
            ]);
        }

        if ($lelang->status_lelang_pivot()->where('status_lelang_id', $statusLelangVerifikasi->status_lelang_id)->count() == 0) {
            $lelang->status_lelang_pivot()->create([
                'status_lelang_id' => $statusLelangVerifikasi->status_lelang_id,
                'is_aktif' => false,
            ]);
        }

        if ($request->konfirmasi == 'true') {
            if ($lelang->status_lelang_pivot()->where('status_lelang_id', $statusLelangAktif->status_lelang_id)->count() == 0) {
                $lelang->status_lelang_pivot()->create([
                    'status_lelang_id' => $statusLelangAktif->status_lelang_id,
                    'is_aktif' => true,
                ]);
            }

            if ($request->jenis_penyelenggaraan == 'online') {
                $request->validate([
                    'master_sesi_lelang_id' => ['required'],
                    'tanggal' => ['required'],
                ]);

                $jenisPlatform = $lelang->jenis_platform_lelang()->create([
                    'online' => true,
                    'offline' => false
                ]);

                $lelang_sesi_online = $lelang->lelang_sesi_online()->create([
                    'master_sesi_lelang_id' => $request->master_sesi_lelang_id,
                    'tanggal' => $request->tanggal,
                    'is_verification_admin' => true
                ]);
            } else {
                $request->validate([
                    'event_lelang' => ['required']
                ]);

                if ($request->jenis_penyelenggaraan == 'hybrid') {
                    $jenisPlatform = $lelang->jenis_platform_lelang()->create([
                        'online' => true,
                        'offline' => true
                    ]);
                } else {
                    $jenisPlatform = $lelang->jenis_platform_lelang()->create([
                        'online' => false,
                        'offline' => true
                    ]);
                }

                DB::table('event_lelang_relation')->insert([
                    'event_lelang_id' => $request->event_lelang,
                    'lelang_id' => $lelang->lelang_id
                ]);
            }

            return redirect('/transaksi/verifikasi_lelang/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di verifikasi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $lelang->status_lelang_pivot()->create([
                'status_lelang_id' => $statusLelangTolak->status_lelang_id,
                'is_aktif' => true,
            ]);

            return redirect('/transaksi/verifikasi_lelang/ditolak/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di verifikasi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
}
