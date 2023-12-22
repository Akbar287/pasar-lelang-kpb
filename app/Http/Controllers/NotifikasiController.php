<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Userlogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\DataTables;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Auth::user()->informasi_akun()->first()->notifikasi()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_read', function ($row) {
                    $actionBtn = $row->is_read ? '<div class="badge badge-success">Dibaca</div>' : '<div class="badge badge-primary">Belum</div>';
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $actionBtn = $row->created_at->format('d F Y');
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('notifikasi.show', $row->notifikasi_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_read'])
                ->make(true);
        }
        return view('notifikasi/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notifikasi $notifikasi)
    {
        $notifikasi->update([
            'is_read' => true
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function read(Request $request, Notifikasi $notifikasi)
    {
        $notifikasi->update($this->notifikasiData());
    }

    public function notifikasiData()
    {
        return [
            'judul' => request('judul'),
            'konten' => request('konten'),
            'is_read' => false,
        ];
    }

    public function notifikasi(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();
            $notifikasi = Notifikasi::where('informasi_akun_id', $user->informasi_akun_id)->orderBy('created_at', 'desc')->paginate(request('page'));

            return response()->json([
                'data' => [
                    'notifikasi' => $notifikasi
                ],
                'message' => 'Notifikasi has been catched',
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
