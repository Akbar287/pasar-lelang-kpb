<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\InformasiAkun;
use App\Models\StatusMember;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'ktp' => ['required', 'string', 'max:16'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_hp' => ['required', 'string', 'min:8', 'max:16'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string'],
            'username' => ['required', 'string', 'min:6', 'max:16'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $informasi_akun = InformasiAkun::create([
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'no_wa' => '0',
            'no_fax' => '0',
            'avatar' => 'default.png'
        ]);

        $statusMember = StatusMember::where('nama_status', 'Calon Anggota')->first();
        $member = $informasi_akun->member()->create([
            'status_member_id' => $statusMember->status_member_id
        ]);

        $member->ktp()->create([
            'nik' => $data['ktp'],
            'nama' => $data['nama'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'verified' => true
        ]);

        return $informasi_akun->userlogin()->create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'is_aktif' => true,
        ]);
    }
}
