<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengeluaranJaminanRequest;
use App\Models\InformasiAkun;
use App\Models\Jaminan;
use App\Models\JenisPengeluaranJaminan;
use App\Models\PengeluaranJaminan;
use App\Models\RegistrasikomoditasJaminan;
use App\Models\StatusMember;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PengeluaranJaminanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PengeluaranJaminan::select('pengeluaran_jaminan.*')->leftJoin('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id', 'pengeluaran_jaminan.pengeluaran_jaminan_id')->whereNull('pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $actionBtn = $row->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('jumlah', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->jumlah, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('jenis', function ($row) {
                    $actionBtn = '<div class="badge badge-primary">' . $row->jenis_pengeluaran_jaminan()->first()->nama_jenis . '</div>';
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->is_aktif ? '<div class="badge badge-success">Disetujui</div>' : (!is_null($row->verified_log()->first()) ? '<div class="badge badge-danger">Ditolak</div>' : '<div class="badge badge-primary">Belum Verifikasi</div>');
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.pengeluaran.show', $row->pengeluaran_jaminan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status', 'jenis'])
                ->make(true);
        }
        return view('administrasi/jaminan/pengeluaran/pengeluaran/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $informasiAkun = StatusMember::where('nama_status', 'Aktif')->first()->member()->select('informasi_akun.informasi_akun_id')->addSelect('member.member_id')->addSelect('ktp.nama')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'member.informasi_akun_id')->join('ktp', 'ktp.member_id', 'member.member_id')->get();
        $jenisPengeluaranJaminan = JenisPengeluaranJaminan::get();
        $kodeTransaksi = $this->transaksiGenerate();

        return view('administrasi/jaminan/pengeluaran/pengeluaran/create', compact('informasiAkun', 'jenisPengeluaranJaminan', 'kodeTransaksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengeluaranJaminanRequest $pengeluaranJaminanRequest)
    {
        $temp = 0;
        // Validate
        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Release Cash Collateral') {
            $pengeluaranJaminanRequest->validate([
                'jumlah' => ['required']
            ]);

            $temp = str_replace(',', '', $pengeluaranJaminanRequest->jumlah);
        }
        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Return Cash Collateral') {
            $pengeluaranJaminanRequest->validate([
                'jumlah_pengembalian' => ['required']
            ]);
            $temp = str_replace(',', '', $pengeluaranJaminanRequest->jumlah_pengembalian);
        }
        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Release Commodity Collateral') {
            $pengeluaranJaminanRequest->validate([
                'registrasi_komoditas_jaminan_id' => ['required'],
                'qty_settlement' => ['required'],
                'alokasi_settlement' => ['required'],
            ]);

            $reg = RegistrasikomoditasJaminan::where('registrasi_komoditas_jaminan_id', $pengeluaranJaminanRequest->registrasi_komoditas_jaminan_id)->first();
            $temp = str_replace(',', '', $reg->nilai_penyesuaian / $reg->kuantitas * $pengeluaranJaminanRequest->qty_settlement);
        }
        // End Validate

        $jenisPengeluaranJaminan = JenisPengeluaranJaminan::where('nama_jenis', $pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id)->first();
        $informasiAkun = InformasiAkun::where('informasi_akun_id', $pengeluaranJaminanRequest->informasi_akun_id)->first();
        $pengeluaranJaminan = $informasiAkun->jaminan()->first()->pengeluaran_jaminan()->create($this->pengeluaranJaminanData($jenisPengeluaranJaminan->jenis_pengeluaran_jaminan_id, $temp));

        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Release Cash Collateral') {
            $pengeluaranJaminan->release_cash()->create($this->releaseCashData($pengeluaranJaminan));
        }
        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Return Cash Collateral') {
            $pengeluaranJaminan->return_cash()->create($this->returnCashData($pengeluaranJaminan));
        }
        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Release Commodity Collateral') {
            $pengeluaranJaminan->jaminan_komoditas()->create($this->jaminanKomoditasData($pengeluaranJaminan, $temp));
        }

        return redirect('/administrasi/jaminan/pengeluaran/' . $pengeluaranJaminan->pengeluaran_jaminan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Pengeluaran Jaminan sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(PengeluaranJaminan $pengeluaranJaminan)
    {
        return view('administrasi/jaminan/pengeluaran/pengeluaran/show', compact('pengeluaranJaminan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengeluaranJaminan $pengeluaranJaminan)
    {
        return view('administrasi/jaminan/pengeluaran/pengeluaran/edit', compact('pengeluaranJaminan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PengeluaranJaminanRequest $pengeluaranJaminanRequest, PengeluaranJaminan $pengeluaranJaminan)
    {
        $temp = 0;
        // Validate
        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Release Cash Collateral') {
            $pengeluaranJaminanRequest->validate([
                'jumlah' => ['required']
            ]);

            $temp = str_replace(',', '', $pengeluaranJaminanRequest->jumlah);
        }
        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Return Cash Collateral') {
            $pengeluaranJaminanRequest->validate([
                'jumlah_pengembalian' => ['required']
            ]);
            $temp = str_replace(',', '', $pengeluaranJaminanRequest->jumlah_pengembalian);
        }
        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Release Commodity Collateral') {
            $pengeluaranJaminanRequest->validate([
                'registrasi_komoditas_jaminan_id' => ['required'],
                'qty_auction' => ['required'],
                'qty_settled' => ['required'],
                'qty_settlement' => ['required'],
                'alokasi_settlement' => ['required'],
            ]);

            $reg = RegistrasikomoditasJaminan::where('registrasi_komoditas_jaminan_id', $pengeluaranJaminanRequest->registrasi_komoditas_jaminan_id)->first();
            $temp = str_replace(',', '', $reg->nilai_penyesuaian / $reg->kuantitas * $pengeluaranJaminanRequest->qty_settlement);
        }

        $pengeluaranJaminan->update($this->pengeluaranJaminanData($pengeluaranJaminan->jenis_pengeluaran_jaminan_id, $temp));

        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Release Cash Collateral') {
            $pengeluaranJaminan->release_cash()->first()->update($this->releaseCashData($pengeluaranJaminan));
        }
        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Return Cash Collateral') {
            $pengeluaranJaminan->return_cash()->first()->update($this->returnCashData($pengeluaranJaminan));
        }
        if ($pengeluaranJaminanRequest->jenis_pengeluaran_jaminan_id == 'Release Commodity Collateral') {
            $pengeluaranJaminan->jaminan_komoditas()->first()->update($this->jaminanKomoditasData($pengeluaranJaminan, $temp));
        }

        return redirect('/administrasi/jaminan/pengeluaran/' . $pengeluaranJaminan->pengeluaran_jaminan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Pengeluaran Jaminan sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengeluaranJaminan $pengeluaranJaminan)
    {
        $pengeluaranJaminan->delete();

        return redirect('/administrasi/jaminan/pengeluaran')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Pengeluaran Jaminan sudah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function pengeluaranJaminanData($jenis_pengeluaran_jaminan_id, $jumlah)
    {
        return [
            'jenis_pengeluaran_jaminan_id' => $jenis_pengeluaran_jaminan_id,
            'kode_transaksi' => request('kode_transaksi'),
            'tanggal' => request('tanggal'),
            'is_aktif' => request('is_aktif'),
            'jumlah' => $jumlah,
            'is_aktif' => false,
            'keterangan' => request('keterangan')
        ];
    }

    public function releaseCashData($pengeluaranJaminan)
    {
        return [
            'pengeluaran_jaminan_id' => $pengeluaranJaminan->pengeluaran_jaminan_id,
            'jumlah' => str_replace(',', '', request('jumlah'))
        ];
    }
    public function returnCashData($pengeluaranJaminan)
    {
        return [
            'pengeluaran_jaminan_id' => $pengeluaranJaminan->pengeluaran_jaminan_id,
            'jumlah_pengembalian' => str_replace(',', '', request('jumlah_pengembalian'))
        ];
    }
    public function jaminanKomoditasData($pengeluaranJaminan, $temp)
    {
        return [
            'pengeluaran_jaminan_id' => $pengeluaranJaminan->pengeluaran_jaminan_id,
            'registrasi_komoditas_jaminan_id' => request('registrasi_komoditas_jaminan_id'),
            'qty_settlement' => str_replace(',', '', request('qty_settlement')),
            'alokasi_settlement' => $temp,
        ];
    }

    public function transaksiGenerate()
    {
        $loop = true;
        $i = 1;
        do {
            $temp = 'TRANS-OUT/' . date('d/m/Y') . '/' . $i;
            $re = PengeluaranJaminan::where('kode_transaksi', $temp)->count();

            if ($re == 0) {
                $loop = false;
            } else {
                $i++;
            }
        } while ($loop);

        return $temp;
    }

    public function get_komoditas(Request $request)
    {
        $request->validate([
            'informasi_akun_id' => ['required'],
        ]);

        $jaminan = Jaminan::where('informasi_akun_id', $request->informasi_akun_id)->first();
        $data = [
            'komoditas' => RegistrasikomoditasJaminan::select('registrasi_komoditas_jaminan.registrasi_komoditas_jaminan_id')->addSelect('registrasi_komoditas_jaminan.komoditi')->addSelect('registrasi_komoditas_jaminan.kuantitas')->addSelect('registrasi_komoditas_jaminan.unit')->addSelect('registrasi_komoditas_jaminan.nilai_perkiraan')->addSelect('registrasi_komoditas_jaminan.haircut')->addSelect('registrasi_komoditas_jaminan.nilai_penyesuaian')->join('detail_jaminan', 'detail_jaminan.detail_jaminan_id', 'registrasi_komoditas_jaminan.detail_jaminan_id')->join('jaminan', 'jaminan.jaminan_id', 'detail_jaminan.jaminan_id')->where('jaminan.informasi_akun_id', $request->informasi_akun_id)->get(),
            'total_saldo_tersedia' => is_null($jaminan) ? 0.00 : $jaminan->saldo_tersedia
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'jaminan komoditas has been catched'
        ], 200);
    }
}
