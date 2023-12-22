<?php

namespace App\Http\Controllers\User\Kontrak;

use App\Http\Controllers\Controller;
use App\Models\JenisPerdagangan;
use App\Models\Komoditas;
use App\Models\Kontrak;
use App\Models\Mutu;
use App\Models\PenyelenggaraPasarLelang;
use App\Models\StatusKontrak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class KontrakUserPengajuanController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first();
            $data = Auth::user()->informasi_akun()->first()->kontrak()->where('status_kontrak_id', $status->status_kontrak_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('penyelenggara', function ($row) {
                    return $row->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama;
                })
                ->addColumn('komoditas', function ($row) {
                    $actionBtn = $row->komoditas()->first()->nama_komoditas;
                    return $actionBtn;
                })
                ->addColumn('jenis_perdagangan', function ($row) {
                    $actionBtn = $row->jenis_perdagangan()->first()->nama_perdagangan;
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->status_kontrak()->first()->nama_status;
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $actionBtn = is_null($row->created_at) ? "Tidak ada Data" : $row->created_at->toDateTimeString();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('kontrak.pengajuan.show', $row->kontrak_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('user/kontrak_pasar_lelang/pengajuan/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        $komoditas = Komoditas::select('komoditas_id')->addSelect('nama_komoditas')->where('kadaluarsa', false)->get();
        $jenisPerdagangan = JenisPerdagangan::select('jenis_perdagangan_id')->addSelect('nama_perdagangan')->where('is_aktif', true)->get();
        $mutu = Mutu::select('mutu_id')->addSelect('nama_mutu')->where('is_aktif', true)->get();
        return view('user.kontrak_pasar_lelang.pengajuan.create', compact('penyelenggaraPasarLelang', 'komoditas', 'jenisPerdagangan', 'mutu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penyelenggara_pasar_lelang_id' => ['required'],
            'mutu_id' => ['required'],
            'komoditas_id' => ['required'],
            'jenis_perdagangan_id' => ['required'],
            'minimum_transaksi' => ['required'],
            'maksimum_transaksi' => ['required'],
            'fluktuasi_harga_harian' => ['required'],
            'premium' => ['required'],
            'diskon' => ['required'],
            'jatuh_tempo_t_plus' => ['required']
        ]);

        $status = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first();
        $jenisPerdagangan = JenisPerdagangan::select('jenis_perdagangan_id')->addSelect('nama_perdagangan')->where('jenis_perdagangan_id', request('jenis_perdagangan_id'))->first();
        $kontrak = PenyelenggaraPasarLelang::where('penyelenggara_pasar_lelang_id', request('penyelenggara_pasar_lelang_id'))->first()->kontrak()->create($this->pengaturanKontrakData($status, Auth::user()->informasi_akun_id, $this->generateSimbol()));

        $kontrak->kontrak_keuangan()->create($this->pengaturanKontrakKeuangan());

        return redirect('/kontrak/pengajuan/' . $kontrak->kontrak_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di tambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontrak $kontrak)
    {
        return view('user/kontrak_pasar_lelang/pengajuan/show', compact('kontrak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontrak $kontrak)
    {
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        $komoditas = Komoditas::select('komoditas_id')->addSelect('nama_komoditas')->where('kadaluarsa', false)->get();
        $jenisPerdagangan = JenisPerdagangan::select('jenis_perdagangan_id')->addSelect('nama_perdagangan')->where('is_aktif', true)->get();
        $mutu = Mutu::select('mutu_id')->addSelect('nama_mutu')->where('is_aktif', true)->get();
        return view('user/kontrak_pasar_lelang/pengajuan/edit', compact('penyelenggaraPasarLelang', 'komoditas', 'jenisPerdagangan', 'mutu', 'kontrak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontrak $kontrak)
    {
        $status = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first();
        $kontrak->update($this->pengaturanKontrakData($status, null, null, true));

        $kontrak->kontrak_keuangan()->first()->update($this->pengaturanKontrakKeuangan());

        return redirect('/kontrak/pengajuan/' . $kontrak->kontrak_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontrak $kontrak)
    {
        $kontrak->delete();

        return redirect('/kontrak/pengajuan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function pengaturanKontrakData($status = null, $informasiAkun = null, $simbol = null, $update = null)
    {
        return $update ?
            [
                'penyelenggara_pasar_lelang_id' => request('penyelenggara_pasar_lelang_id'),
                'mutu_id' => request('mutu_id'),
                'komoditas_id' => request('komoditas_id'),
                'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
                'status_kontrak_id' => $status != null ? $status->status_kontrak_id : 1,
                'minimum_transaksi' => is_null(request('minimum_transaksi')) ? 0 : (str_replace(',', '', request('minimum_transaksi'))),
                'maksimum_transaksi' => is_null(request('maksimum_transaksi')) ? 0 : (str_replace(',', '', request('maksimum_transaksi'))),
                'keterangan' => request('keterangan'),
            ]
            : [
                'penyelenggara_pasar_lelang_id' => request('penyelenggara_pasar_lelang_id'),
                'mutu_id' => request('mutu_id'),
                'kontrak_kode' => $this->generateKontrakKode(is_null($informasiAkun) ? request('informasi_akun_id') : $informasiAkun),
                'komoditas_id' => request('komoditas_id'),
                'informasi_akun_id' => is_null($informasiAkun) ? request('informasi_akun_id') : $informasiAkun,
                'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
                'status_kontrak_id' => $status != null ? $status->status_kontrak_id : 1,
                'simbol' => is_null($simbol) ? request('simbol') : $simbol,
                'minimum_transaksi' => is_null(request('minimum_transaksi')) ? 0 : (str_replace(',', '', request('minimum_transaksi'))),
                'maksimum_transaksi' => is_null(request('maksimum_transaksi')) ? 0 : (str_replace(',', '', request('maksimum_transaksi'))),
                'fluktuasi_harga_harian' => is_null(request('fluktuasi_harga_harian')) ? 0 : (str_replace(',', '', request('fluktuasi_harga_harian'))),
                'premium' => is_null(request('premium')) ? 0 : (str_replace(',', '', request('premium'))),
                'diskon' => is_null(request('diskon')) ? 0 : (str_replace(',', '', request('diskon'))),
                'jatuh_tempo_t_plus' => request('jatuh_tempo_t_plus'),
                'tanggal_aktif' => is_null(request('tanggal_aktif')) ? date('Y-m-d') : request('tanggal_aktif'),
                'tanggal_berakhir' => is_null(request('tanggal_berakhir')) ? Carbon::now()->addMonths(6)->format('Y-m-d') : request('tanggal_berakhir'),
                'keterangan' => request('keterangan'),
                'tanggal_verifikasi' => null,
                'is_aktif' => false,
                'is_verified' => false,
                'is_status_verified' => false,
            ];
    }

    public function pengaturanKontrakKeuangan()
    {
        return [
            'jaminan_lelang' => is_null(request('jaminan_lelang')) ? 0 : str_replace(',', '', request('jaminan_lelang')),
            'denda' => is_null(request('denda')) ? 0 : str_replace(',', '', request('denda')),
            'fee_penjual' => is_null(request('fee_penjual')) ? 0 : str_replace(',', '', request('fee_penjual')),
            'fee_pembeli' => is_null(request('fee_pembeli')) ? 0 : str_replace(',', '', request('fee_pembeli')),
        ];
    }

    public function generateSimbol()
    {
        $komoditas = Komoditas::where('komoditas_id', request('komoditas_id'))->first();
        $jenisPerdagangan = JenisPerdagangan::where('jenis_perdagangan_id', request('jenis_perdagangan_id'))->first();

        $loop = true;
        $i = 1;
        do {
            $temp = strtoupper($jenisPerdagangan->nama_perdagangan) . '-' .  strtoupper($komoditas->nama_komoditas) . '-' . $i;
            $re = Kontrak::where('simbol', $temp)->count();

            if ($re == 0) {
                $loop = false;
            } else {
                $i++;
            }
        } while ($loop);

        return $temp;
    }

    public function generateKontrakKode($id)
    {
        $informasiAkun = Auth::user()->informasi_akun()->first();
        $kontrakCount = is_null($informasiAkun->kontrak()->first()) ? 0 : $informasiAkun->kontrak()->count();
        return 'KONTRAK/' . date('Y') . '/' . $informasiAkun->userlogin()->first()->username . '/' . $kontrakCount;
    }
}
