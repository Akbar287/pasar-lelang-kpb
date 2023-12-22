<?php

namespace App\Http\Controllers\Administrasi\KasBank;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\Userlogin;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\DataTables;

class ListKasBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Keuangan::select('keuangan.*')->addSelect('keuangan_verified_log.verified_log_id')->join('keuangan_verified_log', 'keuangan_verified_log.keuangan_id', 'keuangan.keuangan_id')->join('verified_log', 'verified_log.verified_log_id', 'keuangan_verified_log.verified_log_id')->where('verified_log.is_agree', true)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jenis_transaksi', function ($row) {
                    $actionBtn = $row->jenis_transaksi()->first()->nama_jenis;
                    return $actionBtn;
                })
                ->addColumn('nomor_instruksi', function ($row) {
                    $actionBtn = $row->nomor_instruksi;
                    return $actionBtn;
                })
                ->addColumn('saldo', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->saldo_belum_teralokasi, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('jumlah', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->jumlah, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('kurs_mata_uang', function ($row) {
                    $actionBtn = $row->kurs_mata_uang()->first()->mata_uang_asal . ' - ' . $row->kurs_mata_uang()->first()->mata_uang_tujuan;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.kas_bank.list.show', $row->keuangan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/kas_bank/list/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keuangan $keuangan)
    {
        return view('administrasi/kas_bank/list/show', compact('keuangan'));
    }

    public function getKeuanganSaldo()
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();
            $saldo = 0;

            $total = $user->informasi_akun()->first()->rekening_bank()->select('rekening_bank_id')->addSelect('nomor_rekening')->addSelect('saldo')->addSelect('nama_pemilik')->addSelect('cabang')->get();
            foreach ($user->informasi_akun()->first()->rekening_bank()->get() as $rb) {
                $saldo += $rb->saldo;
            }

            return response()->json([
                'data' => [
                    'saldo' => $saldo,
                    'rekening_bank' => $total
                ],
                'message' => 'saldo rekening bank has been catched',
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
