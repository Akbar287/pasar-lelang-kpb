<?php

namespace App\Http\Controllers\MasterData\Kontrak;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengaturanKontrakRequest;
use App\Models\Admin;
use App\Models\InformasiAkun;
use App\Models\JenisPerdagangan;
use App\Models\Komoditas;
use App\Models\Kontrak;
use App\Models\Mutu;
use App\Models\PenyelenggaraPasarLelang;
use App\Models\StatusKontrak;
use App\Models\StatusMember;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PengaturanKontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first()->kontrak()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    if (!is_null($row->informasi_akun()->first()->lembaga()->first())) {
                        $actionBtn = $row->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                    } else {
                        $actionBtn = $row->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('komoditas', function ($row) {
                    $actionBtn = $row->komoditas()->first()->nama_komoditas;
                    return $actionBtn;
                })
                ->addColumn('jenis_perdagangan', function ($row) {
                    $actionBtn = $row->jenis_perdagangan()->first()->nama_perdagangan;
                    return $actionBtn;
                })
                ->addColumn('username', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->userlogin()->first()->username;
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
                    $actionBtn = '<a href="' . route('master.kontrak.pengaturan.show', $row->kontrak_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/kontrak_pasar_lelang/pengaturan_kontrak/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $komoditas = Komoditas::where('kadaluarsa', false)->get();
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        $mutu = Mutu::where('is_aktif', true)->get();
        $jenisPerdagangan = JenisPerdagangan::where('is_aktif', true)->get();
        $informasiAkun = StatusMember::where('nama_status', 'Aktif')->first()->member()->get();
        return view('master_data/kontrak_pasar_lelang/pengaturan_kontrak/create', compact('komoditas', 'penyelenggaraPasarLelang', 'mutu', 'jenisPerdagangan', 'informasiAkun'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengaturanKontrakRequest $pengaturanKontrakRequest)
    {
        $status = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first();

        $informasi = InformasiAkun::where('informasi_akun_id', $pengaturanKontrakRequest->informasi_akun_id)->first();
        $kontrak = $informasi->kontrak()->create($this->pengaturanKontrakData($status));

        $kontrakKeuangan = $kontrak->kontrak_keuangan()->create($this->pengaturanKontrakKeuangan());

        return redirect('/master/kontrak/pengaturan/' . $kontrak->kontrak_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di tambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontrak $kontrak)
    {
        return view('master_data/kontrak_pasar_lelang/pengaturan_kontrak/show', compact('kontrak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontrak $kontrak)
    {
        $komoditas = Komoditas::where('kadaluarsa', false)->get();
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        $mutu = Mutu::where('is_aktif', true)->get();
        $jenisPerdagangan = JenisPerdagangan::where('is_aktif', true)->get();
        $informasiAkun = StatusMember::where('nama_status', 'Aktif')->first()->member()->get();
        return view('master_data/kontrak_pasar_lelang/pengaturan_kontrak/edit', compact('komoditas', 'penyelenggaraPasarLelang', 'mutu', 'jenisPerdagangan', 'informasiAkun', 'kontrak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PengaturanKontrakRequest $pengaturanKontrakRequest, Kontrak $kontrak)
    {
        $status = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first();

        $kontrak->update($this->pengaturanKontrakData($status));

        $kontrak->kontrak_keuangan()->first()->update($this->pengaturanKontrakKeuangan());

        return redirect('/master/kontrak/pengaturan/' . $kontrak->kontrak_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontrak $kontrak)
    {
        $kontrak->delete();

        return redirect('/master/kontrak/pengaturan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function generateKontrakKode($id)
    {
        $informasiAkun = InformasiAkun::where('informasi_akun_id', $id)->first();
        $kontrakCount = $informasiAkun->kontrak()->count();
        return 'KONTRAK/' . date('Y') . '/' . $informasiAkun->userlogin()->first()->username . '/' . $kontrakCount;
    }

    public function pengaturanKontrakData($status = null)
    {
        return [
            'penyelenggara_pasar_lelang_id' => request('penyelenggara_pasar_lelang_id'),
            'mutu_id' => request('mutu_id'),
            'kontrak_kode' => $this->generateKontrakKode(request('informasi_akun_id')),
            'komoditas_id' => request('komoditas_id'),
            'informasi_akun_id' => request('informasi_akun_id'),
            'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
            'status_kontrak_id' => $status != null ? $status->status_kontrak_id : 1,
            'simbol' => request('simbol'),
            'minimum_transaksi' => str_replace(',', '', request('minimum_transaksi')),
            'maksimum_transaksi' => str_replace(',', '', request('maksimum_transaksi')),
            'fluktuasi_harga_harian' => str_replace(',', '', request('fluktuasi_harga_harian')),
            'premium' => str_replace(',', '', request('premium')),
            'diskon' => str_replace(',', '', request('diskon')),
            'jatuh_tempo_t_plus' => request('jatuh_tempo_t_plus'),
            'tanggal_aktif' => request('tanggal_aktif'),
            'tanggal_berakhir' => request('tanggal_berakhir'),
            'tanggal_verifikasi' => null,
            'is_aktif' => false,
            'is_verified' => false,
            'is_status_verified' => false,
        ];
    }

    public function pengaturanKontrakKeuangan()
    {
        return [
            'jaminan_lelang' => str_replace(',', '', request('jaminan_lelang')),
            'denda' => str_replace(',', '', request('denda')),
            'fee_penjual' => str_replace(',', '', request('fee_penjual')),
            'fee_pembeli' => str_replace(',', '', request('fee_pembeli')),
        ];
    }
}
