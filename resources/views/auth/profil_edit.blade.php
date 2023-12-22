@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Ubah Profil</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil') }}">Profil</a></div>
        <div class="breadcrumb-item">Ubah Profil</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Profil</h2>
    <p class="section-lead">
        Ubah Profil.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('home.profil.update') }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                @if(!is_null(Auth::user()->informasi_akun()->first()->member()->first()))
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Data Diri') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="nik" class="col-md-4 col-form-label text-md-end">{{ __('NIK')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nik" type="text" placeholder="NIK"
                                            class="form-control @error('nik') is-invalid @enderror" name="nik"
                                            value="{{ Auth::user()->informasi_akun()->first()->member()->first()->ktp()->first()->nik }}" />

                                        @error('nik')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nama" type="text"
                                            class="form-control @error('nama') is-invalid @enderror" name="nama"
                                            value="{{ Auth::user()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}" />

                                        @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_kelamin" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Kelamin')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select id="jenis_kelamin" type="text" class="custom-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin">
                                            <option {{ Auth::user()->informasi_akun()->first()->member()->first()->ktp()->first()->jenis_kelamin == 'pria' ? 'selected' : '' }} value="{{ 'pria' }}">Pria</option>
                                            <option {{ Auth::user()->informasi_akun()->first()->member()->first()->ktp()->first()->jenis_kelamin == 'wanita' ? 'selected' : '' }} value="{{ 'wanita' }}">Wanita</option>
                                        </select>

                                        @error('jenis_kelamin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="tempat_lahir" class="col-md-4 col-form-label text-md-end">{{ __('Tempat Lahir')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="tempat_lahir" type="text"
                                            class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir"
                                            value="{{ Auth::user()->informasi_akun()->first()->member()->first()->ktp()->first()->tempat_lahir }}" />

                                        @error('tempat_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_lahir" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Lahir')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="tanggal_lahir" type="date"
                                            class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir"
                                            value="{{ Auth::user()->informasi_akun()->first()->member()->first()->ktp()->first()->tanggal_lahir }}" />

                                        @error('tanggal_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="text" readonly
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ Auth::user()->informasi_akun()->first()->email }}" />

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" readonly
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ Auth::user()->username }}" />

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_hp" class="col-md-4 col-form-label text-md-end">{{ __('No. HP')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="no_hp" type="text"
                                            class="form-control @error('no_hp') is-invalid @enderror" name="no_hp"
                                            value="{{ Auth::user()->informasi_akun()->first()->no_hp }}" />

                                        @error('no_hp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_wa" class="col-md-4 col-form-label text-md-end">{{ __('No. WA')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="no_wa" type="text"
                                            class="form-control @error('no_wa') is-invalid @enderror" name="no_wa"
                                            value="{{ Auth::user()->informasi_akun()->first()->no_wa }}" />

                                        @error('no_wa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_fax" class="col-md-4 col-form-label text-md-end">{{ __('No. Fax')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="no_fax" type="text"
                                            class="form-control @error('no_fax') is-invalid @enderror" name="no_fax"
                                            value="{{ Auth::user()->informasi_akun()->first()->no_fax }}" />

                                        @error('no_fax')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="keterangan" type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                                            value="{{ is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? '' : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->keterangan }}" />

                                        @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Informasi Keuangan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="pekerjaan" class="col-md-4 col-form-label text-md-end">{{ __('Pekerjaan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="pekerjaan" type="text" placeholder="pekerjaan"
                                            class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan"
                                            value="{{ is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? old('pekerjaan') : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->pekerjaan }}" />

                                        @error('pekerjaan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="pendapatan_tahunan" class="col-md-4 col-form-label text-md-end">{{ __('Pendapatan Tahunan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('pendapatan_tahunan') is-invalid @enderror" name="pendapatan_tahunan" id="pendapatan_tahunan">
                                            <option {{ (is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? old('pendapatan_tahunan') : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan) == '0-1.000.000' ? 'selected' : '' }} value='0-1.000.000'>0-Rp. 1.000.000</option>
                                            <option {{ (is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? old('pendapatan_tahunan') : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan) == '1.000.001-10.000.000' ? 'selected' : '' }} value='1.000.001-10.000.000'>Rp. 1.000.001-Rp. 10.000.000</option>
                                            <option {{ (is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? old('pendapatan_tahunan') : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan) == '10.000.001-50.000.000' ? 'selected' : '' }} value='10.000.001-50.000.000'>Rp. 10.000.001-Rp. 50.000.000</option>
                                            <option {{ (is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? old('pendapatan_tahunan') : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan) == '50.000.001-100.000.000' ? 'selected' : '' }} value='50.000.001-100.000.000'>Rp. 50.000.001-Rp. 100.000.000</option>
                                            <option {{ (is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? old('pendapatan_tahunan') : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan) == 'Diatas 100.000.000' ? 'selected' : '' }} value='Diatas 100.000.000'>Diatas Rp. 100.000.000</option>
                                        </select>

                                        @error('pendapatan_tahunan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="kekayaan_bersih" class="col-md-4 col-form-label text-md-end">{{ __('Kekayaan Bersih')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input id="kekayaan_bersih" type="text"
                                                    class="form-control thousand-style @error('kekayaan_bersih') is-invalid @enderror" name="kekayaan_bersih"
                                                    value="{{ is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? old('kekayaan_bersih') : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->kekayaan_bersih }}" />
                                            </div>
                                        </div>

                                        @error('kekayaan_bersih')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="kekayaan_lancar" class="col-md-4 col-form-label text-md-end">{{ __('Kekayaan Lancar')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input id="kekayaan_lancar" type="text"
                                                    class="form-control thousand-style @error('kekayaan_lancar') is-invalid @enderror" name="kekayaan_lancar"
                                                    value="{{ is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? old('kekayaan_lancar') : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->kekayaan_lancar }}" />
                                            </div>
                                        </div>

                                        @error('kekayaan_lancar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="sumber_dana" class="col-md-4 col-form-label text-md-end">{{ __('Sumber Dana')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="sumber_dana" type="text"
                                            class="form-control @error('sumber_dana') is-invalid @enderror" name="sumber_dana"
                                            value="{{ is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? old('sumber_dana') : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->sumber_dana }}" />

                                        @error('sumber_dana')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="npwp" class="col-md-4 col-form-label text-md-end">{{ __('NPWP')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="npwp" type="text"
                                            class="form-control @error('npwp') is-invalid @enderror" name="npwp"
                                            value="{{ is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? '' : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->npwp()->first()->npwp }}" />

                                        @error('npwp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="keterangan" type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                                            value="{{ is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) ? '' : Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->keterangan }}" />

                                        @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Pilihan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                        <a type="button" href="{{ route('home.profil') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <button type="submit" class="btn btn-success mr-2"><i class="fas fa-pen"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
