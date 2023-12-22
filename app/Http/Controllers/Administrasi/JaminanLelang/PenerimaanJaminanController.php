<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenerimaanJaminanRequest;
use App\Models\DetailJaminan;
use App\Models\InformasiAkun;
use App\Models\StatusMember;
use App\Models\Userlogin;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\DataTables;

class PenerimaanJaminanController extends Controller
{
    public function api(Request $request)
    {
        $request->validate([
            'code' => ['required']
        ]);

        if ($request->code == 'get-jaminan') {
            $request->validate([
                'informasi_akun_id' => ['required']
            ]);

            $informasi = InformasiAkun::where('informasi_akun_id', $request->informasi_akun_id)->first();

            if (is_null($informasi->jaminan()->first())) {
                $data = $informasi->jaminan()->create([
                    'total_saldo_jaminan' => 0,
                    'saldo_teralokasi' => 0,
                    'saldo_tersedia' => 0
                ]);
            } else {
                $data = $informasi->jaminan()->first();
            }

            return response()->json([
                'data' => $data,
                'message' => 'jaminan has been catched',
                'status' => 'success'
            ], 200);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DetailJaminan::select('detail_jaminan.*')->leftJoin('detail_jaminan_verified_log', 'detail_jaminan_verified_log.detail_jaminan_id', 'detail_jaminan.detail_jaminan_id')->whereNull('detail_jaminan_verified_log.detail_jaminan_id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $actionBtn = $row->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('nilai_jaminan', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_jaminan, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('nilai_penyesuaian', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_penyesuaian, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.penerimaan.show', $row->detail_jaminan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/jaminan/penerimaan/penerimaan/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $informasiAkun = StatusMember::where('nama_status', 'Aktif')->first()->member()->select('member.member_id')->addSelect('informasi_akun.informasi_akun_id')->addSelect('ktp.nama')->addSelect('jaminan.*')->addSelect('ktp.nik')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'member.informasi_akun_id')->join('ktp', 'ktp.member_id', 'member.member_id')->join('jaminan', 'jaminan.informasi_akun_id', 'informasi_akun.informasi_akun_id')->get();
        return view('administrasi/jaminan/penerimaan/penerimaan/create', compact('informasiAkun'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenerimaanJaminanRequest $penerimaanJaminanRequest)
    {
        $informasiAkun = InformasiAkun::where('informasi_akun_id', $penerimaanJaminanRequest->informasi_akun_id)->first();

        if (is_null($informasiAkun->jaminan()->first())) {
            $temp = $informasiAkun->jaminan()->create([
                'total_saldo_jaminan' => 0,
                'saldo_teralokasi' => 0,
                'saldo_tersedia' => 0
            ]);
        } else {
            $temp = $informasiAkun->jaminan()->first();
        }

        $detailJaminan = $temp->detail_jaminan()->create($this->detailJaminanData());

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jaminan sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailJaminan $detailJaminan)
    {
        return view('administrasi/jaminan/penerimaan/penerimaan/show', compact('detailJaminan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailJaminan $detailJaminan)
    {
        $informasiAkun = StatusMember::where('nama_status', 'Aktif')->first()->member()->select('member.member_id')->addSelect('informasi_akun.informasi_akun_id')->addSelect('ktp.nama')->addSelect('jaminan.*')->addSelect('ktp.nik')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'member.informasi_akun_id')->join('ktp', 'ktp.member_id', 'member.member_id')->join('jaminan', 'jaminan.informasi_akun_id', 'informasi_akun.informasi_akun_id')->get();

        return view('administrasi/jaminan/penerimaan/penerimaan/edit', compact('detailJaminan', 'informasiAkun'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenerimaanJaminanRequest $penerimaanJaminanRequest, DetailJaminan $detailJaminan)
    {
        $detailJaminan->update($this->detailJaminanData());

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jaminan sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailJaminan $detailJaminan)
    {
        $detailJaminan->delete();

        return redirect('/administrasi/jaminan/penerimaan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jaminan sudah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function detailJaminanData()
    {
        return [
            'tanggal_transaksi' => request('tanggal'),
            'nilai_jaminan' => 0,
            'nilai_penyesuaian' => 0,
            'is_aktif' => false,
        ];
    }

    public function getJaminanByUser()
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();

            if (is_null($user->informasi_akun()->first()->jaminan()->first())) {
                $user->informasi_akun()->first()->jaminan()->create([
                    'total_saldo_jaminan' => 0,
                    'saldo_teralokasi' => 0,
                    'saldo_tersedia' => 0
                ]);
            }

            $total = $user->informasi_akun()->first()->jaminan()->first();

            return response()->json([
                'data' => $total,
                'message' => 'saldo jaminan has been catched',
                'status' => 'success'
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_expired: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        } catch (TokenInvalidException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_invalid: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        } catch (JWTException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_absent: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        }
    }
}
