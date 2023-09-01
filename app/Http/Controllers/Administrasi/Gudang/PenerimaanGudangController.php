<?php

namespace App\Http\Controllers\Administrasi\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Gudang;
use App\Models\JenisRegistrasiKomoditas;
use App\Models\Komoditas;
use App\Models\Member;
use App\Models\Mutu;
use App\Models\RegistrasiKomoditas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenerimaanGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RegistrasiKomoditas::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jenis_registrasi', function ($row) {
                    $actionBtn = $row->jenis_transaksi()->first()->nama_jenis;
                    return $actionBtn;
                })
                ->addColumn('kode_transaksi', function ($row) {
                    $actionBtn = $row->kode_transaksi;
                    return $actionBtn;
                })
                ->addColumn('nama_komoditas', function ($row) {
                    $actionBtn = $row->komoditas()->first()->nama_komoditas;
                    return $actionBtn;
                })
                ->addColumn('nama_gudang', function ($row) {
                    $actionBtn = $row->gudang->first()->nama_gudang;
                    return $actionBtn;
                })
                ->addColumn('tanggal', function ($row) {
                    $actionBtn = $row->tanggal;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.gudang.penerimaan.show', $row->registrasi_komoditas_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/gudang/penerimaan/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gudang = Gudang::get();
        $informasi_akun = Member::join('informasi_akun', 'informasi_akun.informasi_akun_id', 'member.informasi_akun_id')->get();
        $mutu = Mutu::where('is_aktif', true)->get();
        $komoditas = Komoditas::get();
        $jenisRegistrasi = JenisRegistrasiKomoditas::get();
        $kodeTransaksi = $this->transaksiGenerate();
        return view('administrasi/gudang/penerimaan/create', compact('gudang', 'jenisRegistrasi', 'komoditas', 'mutu', 'informasi_akun', 'kodeTransaksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_registrasi_id' => ['required'],
            'tanggal' => ['required'],
            'transaksi_id' => ['required'],
            'informasi_akun_id' => ['required'],
            'gudang_id' => ['required'],
            'komoditas_id' => ['required'],
            'mutu_id' => ['required'],
            'nomor_instruksi' => ['required'],
            'nomor_bast' => ['required'],
            'kadaluarsa' => ['required'],
            'kuantitas' => ['required'],
            'nilai' => ['required'],
        ]);

        $jenisRegistrasi = JenisRegistrasiKomoditas::where('nama_jenis', $request->jenis_registrasi_id)->first();
        $registrasi = $jenisRegistrasi->registrasi_komoditas()->create($this->registrasiKomoditasData());

        if ($jenisRegistrasi->nama_jenis == 'Registrasi Komoditas (IN)') {
            $request->validate([
                'saldo_belum_teralokasi' => ['required'],
                'sisa_alokasi' => ['required'],
                'jenis_alokasi' => ['required'],
                'alokasi_collateral' => ['required'],
                'alokasi_penyelesaian' => ['required'],
                'alokasi_lain' => ['required'],
            ]);

            $registrasi->registrasi_komoditas_alokasi()->create($this->registrasiKomoditasAlokasi());
        }


        return redirect('/administrasi/gudang/penerimaan/' . $registrasi->registrasi_komoditas_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Registrasi Komoditas sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(RegistrasiKomoditas $registrasi)
    {
        return view('administrasi/gudang/penerimaan/show', compact('gudang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegistrasiKomoditas $registrasi)
    {
        $gudang = Gudang::get();
        return view('administrasi/gudang/penerimaan/edit', compact('gudang', 'registrasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistrasiKomoditas $registrasi)
    {
        $registrasi->update($this->registrasiKomoditasData());

        return redirect('/administrasi/gudang/penerimaan/' . $registrasi->registrasi_komoditas_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Gudang sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegistrasiKomoditas $registrasi)
    {
        $registrasi->delete();

        return redirect('/administrasi/gudang/penerimaan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Gudang sudah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function transaksiGenerate()
    {
        $loop = true;
        $i = 1;
        do {
            $temp = 'COMM-KPB/' . date('d/m/Y') . '/' . $i;
            $re = RegistrasiKomoditas::where('kode_transaksi', $temp)->count();

            if ($re == 0) {
                $loop = false;
            } else {
                $i++;
            }
        } while ($loop);

        return $temp;
    }

    public function registrasiKomoditasData()
    {
        return [
            'informasi_akun_id' => request('informasi_akun_id'),
            'komoditas_id' => request('komoditas_id'),
            'mutu_id' => request('mutu_id'),
            'gudang_id' => request('gudang_id'),
            'tanggal' => request('tanggal'),
            'kode_transaksi' => request('transaksi_id'),
            'no_instruksi' => request('nomor_instruksi'),
            'quantity' => request('kuantitas'),
            'nilai' => request('nilai'),
            'no_bast' => request('nomor_bast'),
            'kadaluarsa' => request('kadaluarsa'),
            'keterangan' => request('keterangan'),
        ];
    }

    public function registrasiKomoditasAlokasi()
    {
        return [
            'sisa_alokasi_saldo' => 0, // request('sisa_alokasi_saldo'),
            'saldo_belum_teralokasi' => request('saldo_belum_teralokasi'),
            'alokasi_kolateral' => request('alokasi_kolateral'),
            'alokasi_penyelesaian' => request('alokasi_penyelesaian'),
            'alokasi_lain' => request('alokasi_lain'),
            'type_alokasi' => request('type_alokasi'),
        ];
    }
}
