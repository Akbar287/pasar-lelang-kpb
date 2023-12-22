<?php

namespace App\Http\Controllers\Auth;


use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\InformasiAkun;
use App\Models\JenisDokumen;
use App\Models\Npwp;
use App\Models\Role;
use App\Models\StatusMember;
use App\Models\Userlogin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function area_member($area)
    {
        $temp = [];
        foreach ($area as $a) {
            $temp[] = [
                'provinsi' => $a->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->nama_provinsi,
                'kabupaten' => $a->desa()->first()->kecamatan()->first()->kabupaten()->first()->nama_kabupaten,
                'kecamatan' => $a->desa()->first()->kecamatan()->first()->nama_kecamatan,
                'desa' => $a->desa()->first()->nama_desa,
                'kode_pos' => $a->kode_pos,
                'alamat' => $a->alamat,
                'alamat_ke' => $a->alamat_ke
            ];
        }
        return $temp;
    }
    public function profile(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('authorization'));

        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();
            $data = [
                'informasi_akun_id' => $user->informasi_akun_id,
                'member_id' => $user->informasi_akun()->first()->member()->first()->member_id,
                'nik' => $user->informasi_akun()->first()->member()->first()->ktp()->first()->nik,
                'nama' => $user->informasi_akun()->first()->member()->first()->ktp()->first()->nama,
                'jenis_kelamin' => $user->informasi_akun()->first()->member()->first()->ktp()->first()->jenis_kelamin,
                'tempat_lahir' => $user->informasi_akun()->first()->member()->first()->ktp()->first()->tempat_lahir,
                'tanggal_lahir' => $user->informasi_akun()->first()->member()->first()->ktp()->first()->tanggal_lahir,
                'status_member' => $user->informasi_akun()->first()->member()->first()->status_member()->first(),
                'email' => $user->informasi_akun()->first()->email,
                'no_hp' => $user->informasi_akun()->first()->no_hp,
                'no_wa' => $user->informasi_akun()->first()->no_wa,
                'no_fax' => $user->informasi_akun()->first()->no_fax,
                'avatar' => $user->informasi_akun()->first()->avatar,
                'dokumen_member' => $user->informasi_akun()->first()->dokumen_member()->get(),
                'username' => $user->username,
                'status_member' => ($user->informasi_akun()->first()->member()->count() > 0) ? $user->informasi_akun()->first()->member()->first()->status_member()->first()->nama_status : $user->informasi_akun()->first()->lembaga()->first()->status_member()->first()->nama_status,
                'last_login' => $user->last_login,
                'rekening_bank' => $user->informasi_akun()->first()->rekening_bank()->join('bank', 'bank.bank_id', 'rekening_bank.bank_id')->get(),
                'informasi_keuangan' => $user->informasi_akun()->first()->member()->first()->informasi_keuangan()->first(),
                'area_member' => $this->area_member($user->informasi_akun()->first()->area_member()->get()),
                'setting_collateral' => $user->informasi_akun()->first()->member()->first()->setting_collateral()->select('setting_collateral.setting_collateral_id')->addSelect('jenis_inisiasi.nama_inisiasi')->join('jenis_inisiasi', 'jenis_inisiasi.jenis_inisiasi_id', 'setting_collateral.jenis_inisiasi_id')->get(),
                'jaminan' => $user->informasi_akun()->first()->jaminan()->first()
            ];

            return response()->json([
                'data' => $data,
                'message' => 'profile has been catched',
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

    public function register_dokumen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_dokumen_id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        }

        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $foto = '';
            if ($request->hasFile('file')) {
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $foto = $filename . '_' . time() . '.' . $extension;
                $request->file('file')->storeAs('public/dokumen_member', $foto);
            }

            $jenisDokumen = JenisDokumen::where('jenis_dokumen_id', $request->jenis_dokumen_id)->first();
            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();

            $data = $user->informasi_akun()->first()->dokumen_member()->create([
                'jenis_dokumen_id' => $jenisDokumen->jenis_dokumen_id,
                'informasi_akun_id' => $user->informasi_akun()->first()->informasi_akun_id,
                'versi_unggah' => 1,
                'tanggal_unggah' => date('Y-m-d'),
                'nama_dokumen' => $foto,
                'nama_file' => $foto,
            ]);

            return response()->json([
                'data' => $data,
                'message' => 'file dokumen member has been created',
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
    public function register_keuangan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npwp' => ['required'],
            'pekerjaan' => ['required'],
            'pendapatan_tahunan' => ['required'],
            'kekayaan_bersih' => ['required'],
            'kekayaan_lancar' => ['required'],
            'sumber_dana' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        }

        $token = str_replace('Bearer ', '', $request->header('authorization'));

        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();

            $informasi_keuangan = [];
            if ($user->informasi_akun()->first()->member()->first()->informasi_keuangan()->count() > 0) {
                // Informasi Keuangan sudah Ada
                $informasi_keuangan = $user->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->update([
                    'pekerjaan' => request('pekerjaan'),
                    'pendapatan_tahunan' => request('pendapatan_tahunan'),
                    'kekayaan_bersih' => request('kekayaan_bersih'),
                    'kekayaan_lancar' => request('kekayaan_lancar'),
                    'sumber_dana' => request('sumber_dana'),
                ]);

                if ($request->has('npwp')) {
                    $informasi_keuangan->npwp()->first()->update([
                        'npwp' => $request->npwp
                    ]);
                }
            } else {
                $npwp = new Npwp();
                $npwp->npwp = $request->npwp;
                $npwp->save();

                $informasi_keuangan = $npwp->informasi_keuangan()->create([
                    'member_id' => $user->informasi_akun()->first()->member()->first()->member_id,
                    'pekerjaan' => request('pekerjaan'),
                    'pendapatan_tahunan' => request('pendapatan_tahunan'),
                    'kekayaan_bersih' => request('kekayaan_bersih'),
                    'kekayaan_lancar' => request('kekayaan_lancar'),
                    'sumber_dana' => request('sumber_dana'),
                ]);
            }

            return response()->json([
                'data' => $informasi_keuangan,
                'message' => 'register keuangan has been saved',
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
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => ['required', 'size:16'],
            'nama' => ['required'],
            'jenis_kelamin' => ['required'],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required'],
            'email' => ['required', 'email'],
            'no_hp' => ['required'],
            'kode_pos' => ['required'],
            'alamat' => ['required'],
            'desa_id' => ['required'],
            'username' => ['required', 'unique:userlogin,username', 'min:6', 'max:12'],
            'password' => ['required'],
            'confirm_password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        }

        try {
            $informasi_akun = new InformasiAkun();
            $informasi_akun->email = $request->email;
            $informasi_akun->no_hp = $request->no_hp;
            $informasi_akun->no_wa = null;
            $informasi_akun->no_fax = null;
            $informasi_akun->avatar = 'default.png';
            $informasi_akun->save();

            $statusMember = StatusMember::where('nama_status', 'Calon Anggota')->first();
            $member = $informasi_akun->member()->create([
                'status_member_id' => $statusMember->status_member_id
            ]);
            unset($statusMember);

            $ktp = $member->ktp()->create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'verified' => false,
            ]);

            $userlogin = $informasi_akun->userlogin()->create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'is_aktif' => false,
                'access_token' => null,
                'token' => null,
                'last_login'  => null,
            ]);

            $jaminan = $informasi_akun->jaminan()->create([
                'total_saldo_jaminan' => 0,
                'saldo_teralokasi' => 0,
                'saldo_tersedia' => 0,
            ]);

            $role = Role::where('nama_role', 'ROLE_PEMBELI')->first();
            DB::table('role_member')->insert([
                'role_id' => $role->role_id,
                'member_id' => $member->member_id
            ]);
            unset($role);

            $desa = Desa::where('desa_id', request('desa_id'))->first();
            $areaMember = $informasi_akun->area_member()->create([
                'desa_id' => $desa->desa_id,
                'kode_pos' => request('kode_pos'),
                'alamat' => request('alamat'),
                'alamat_ke' => 1,
            ]);

            $token = JWTAuth::fromUser($userlogin);

            return response()->json([
                'data' => [
                    'token' => $token,
                ],
                'message' => 'user has been created',
                'status' => 'success'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => 'user cannot to create because attempted error or missing field from client to server. error: ' . $e->getMessage(),
                'status' => 'error'
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'min:6', 'max:16'],
            'password' => ['required', 'string'],
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
                if (!$token = JWTAuth::attempt(['username' => $request->username, 'password' => $request->password])) {
                    return response()->json([
                        'data' => [],
                        'status' => 'error',
                        'message' => 'Username or Password Wrong'
                    ], 401);
                    exit;
                }
            } catch (JWTException $e) {
                return response()->json([
                    'data' => [],
                    'status' => 'error',
                    'message' => 'Could not create token'
                ], 500);
                exit;
            }

            $user = Userlogin::where('username', $request->username)->first();
            $user->update([
                'last_login' => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'data' => [
                    'token' => $token
                ],
                "message" => 'login successfully',
                "status" => 'success'
            ]);
            exit;

            try {
                if (!$token = JWTAuth::attempt(['username' => $request->username, 'password' => $request->password])) {
                    return response()->json([
                        'data' => [],
                        'status' => 'error',
                        'message' => 'Username or Password Wrong'
                    ], 401);
                    exit;
                }
            } catch (JWTException $e) {
                return response()->json([
                    'data' => [],
                    'status' => 'error',
                    'message' => 'Could not create token'
                ], 500);
                exit;
            }

            $user = Userlogin::where('username', $request->username)->first();
            $user->update([
                'last_login' => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'data' => [
                    'token' => $token
                ],
                "message" => 'login successfully',
                "status" => 'success'
            ]);
            exit;
        }
    }

    public function refreshToken(Request $request)
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());

            return response()->json([
                'data' => [
                    'token' => $newToken
                ],
                'message' => 'token has been renewable',
                'status' => 'success'
            ], 200);
            exit;
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => 'Could not refresh token'
            ], 401);
            exit;
        }
    }

    public function logout(Request $request)
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => 'Token not provided'
            ], 400);
            exit;
        }

        try {
            // Add the token to the blacklist to invalidate it
            // TokenBlacklist::create(['token' => $token]);
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'message' => 'Logout successful',
                'data' => [],
                'status' => 'success'
            ], 200);
            exit;
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => 'Logout failed'
            ], 500);
        }
    }
}
