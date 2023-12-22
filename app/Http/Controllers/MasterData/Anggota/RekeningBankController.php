<?php

namespace App\Http\Controllers\MasterData\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\InformasiAkun;
use App\Models\KursMataUang;
use App\Models\RekeningBank;
use App\Models\Userlogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\DataTables;

class RekeningBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, InformasiAkun $anggota)
    {
        if ($request->ajax()) {
            $data = $anggota->rekening_bank()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_bank', function ($row) {
                    return $row->bank()->first()->nama_bank;
                })
                ->addColumn('saldo', function ($row) {
                    return 'Rp. ' . number_format($row->saldo, 2, ".", ",");
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.anggota.list.rekening.show', [$row->informasi_akun()->first()->informasi_akun_id, $row->rekening_bank_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/anggota_pasar_lelang/rekening_bank/index', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(InformasiAkun $anggota)
    {
        $bank = Bank::get();
        return view('master_data/anggota_pasar_lelang/rekening_bank/create', compact('anggota', 'bank'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, InformasiAkun $anggota)
    {
        $request->validate([
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'nama_pemilik' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required']
        ]);

        $bank = Bank::where('bank_id', $request->bank_id)->first();

        $rekening = $anggota->rekening_bank()->create([
            'bank_id' => $bank->bank_id,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik' => $request->nama_pemilik,
            'cabang' => $request->cabang,
            'mata_uang' => $request->mata_uang,
            'nilai_awal' => 0,
            'saldo' => 0
        ]);

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/rekening/' . $rekening->rekening_bank_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Rekening Bank telah ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(InformasiAkun $anggota, RekeningBank $rekening)
    {
        return view('master_data/anggota_pasar_lelang/rekening_bank/show', compact('rekening', 'anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformasiAkun $anggota, RekeningBank $rekening)
    {
        $bank = Bank::get();
        return view('master_data/anggota_pasar_lelang/rekening_bank/edit', compact('rekening', 'anggota', 'bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformasiAkun $anggota, RekeningBank $rekening)
    {
        $request->validate([
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'nama_pemilik' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required']
        ]);

        $bank = Bank::where('bank_id', $request->bank_id)->first();

        $rekening->update([
            'bank_id' => $bank->bank_id,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik' => $request->nama_pemilik,
            'cabang' => $request->cabang,
            'mata_uang' => $request->mata_uang,
            'nilai_awal' => 0,
            'saldo' => 0
        ]);

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/rekening/' . $rekening->rekening_bank_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Rekening Bank telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformasiAkun $anggota, RekeningBank $rekening)
    {
        $rekening->delete();

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/rekening')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Rekening Bank telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function api_kurs_mata_uang(Request $request)
    {
        $data = KursMataUang::paginate();

        return response()->json([
            'data' => $data,
            'message' => 'token has been catched',
            'status' => 'success'
        ], 200);
    }

    public function api_rekening_bank(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();
            $data = $user->informasi_akun()->first()->rekening_bank()->where(
                'nomor_rekening',
                'LIKE',
                '%' . request('search') . '%'
            )->paginate(request('page'));

            return response()->json([
                'data' => $data,
                'message' => 'rekening bank has been catched',
                'status' => 'success'
            ], 200);
            exit;
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

    public function api_create_rekening_bank(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'nama_pemilik' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required']
        ]);


        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        } else {
            try {
                $token = JWTAuth::getToken();
                $apy = JWTAuth::getPayload($token)->toArray();

                $bank = Bank::where('bank_id', request('bank_id'))->first();
                $user = Userlogin::where('userlogin_id', $apy['sub'])->first();
                $rekening = $user->informasi_akun()->first()->rekening_bank()->create([
                    'bank_id' => $bank->bank_id,
                    'nomor_rekening' => $request->nomor_rekening,
                    'nama_pemilik' => $request->nama_pemilik,
                    'cabang' => $request->cabang,
                    'mata_uang' => $request->mata_uang,
                    'nilai_awal' => 0,
                    'saldo' => 0
                ]);

                return response()->json([
                    'data' => [
                        'rekening_bank' => $rekening
                    ],
                    'message' => 'Rekening Bank has been created',
                    'status' => 'success'
                ], 200);
                exit;
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

    public function api_show_rekening_bank(RekeningBank $rekeningBank)
    {
        return response()->json([
            'data' => [
                'rekening_bank' => $rekeningBank
            ],
            'message' => 'rekening bank has been catched',
            'status' => 'success'
        ], 200);
        exit;
    }

    public function api_update_rekening_bank(Request $request, RekeningBank $rekeningBank)
    {
        $validator = Validator::make(request()->all(), [
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'nama_pemilik' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        } else {
            $bank = Bank::where('bank_id', request('bank_id'))->first();
            $rekeningBank->update([
                'bank_id' => $bank->bank_id,
                'nomor_rekening' => $request->nomor_rekening,
                'nama_pemilik' => $request->nama_pemilik,
                'cabang' => $request->cabang,
                'mata_uang' => $request->mata_uang,
                'nilai_awal' => 0,
                'saldo' => 0
            ]);

            return response()->json([
                'data' => [
                    'rekening_bank' => $rekeningBank
                ],
                'message' => 'Rekening Bank has been updated',
                'status' => 'success'
            ], 200);
            exit;
        }
    }

    public function api_delete_rekening_bank(RekeningBank $rekeningBank)
    {
        $rekeningBank->delete();

        return response()->json([
            'data' => [
                'rekening_bank' => null
            ],
            'message' => 'Rekening Bank has been deleted',
            'status' => 'success'
        ], 200);
        exit;
    }
}
