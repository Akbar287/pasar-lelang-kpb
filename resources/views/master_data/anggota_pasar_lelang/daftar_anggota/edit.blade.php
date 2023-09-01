@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Anggota</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list.show', $anggota->informasi_akun_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Anggota</h2>
    <p class="section-lead">
        Ubah data Anggota.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('master.anggota.list.update', $anggota->informasi_akun_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Jenis Keanggotaan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_aset" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Keanggotaan')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="selectgroup w-100">
                                                @if($anggota->lembaga()->count() > 0)
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="jenis_perseorangan" value="lembaga" class="selectgroup-input" checked>
                                                    <span class="selectgroup-button">Lembaga</span>
                                                </label>
                                                @else 
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="jenis_perseorangan" value="perseorangan" class="selectgroup-input" checked>
                                                    <span class="selectgroup-button">Perseorangan</span>
                                                </label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($anggota->lembaga()->count() > 0)
                <div class="card lembaga">
                    <div class="card-header">
                        <h4>{{ __('Lembaga') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Nama Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nama_lembaga" type="text"
                                            class="form-control @error('nama_lembaga') is-invalid @enderror" name="nama_lembaga"
                                            value="{{ $anggota->lembaga()->first()->nama_lembaga }}" autocomplete="name"
                                            autofocus>
            
                                        @error('nama_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="bidang_usaha" class="col-md-4 col-form-label text-md-end">{{ __('Bidang Usaha')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="bidang_usaha" type="text"
                                            class="form-control @error('bidang_usaha') is-invalid @enderror" name="bidang_usaha"
                                            value="{{ $anggota->lembaga()->first()->bidang_usaha }}" autocomplete="name"
                                            autofocus>
            
                                        @error('bidang_usaha')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="npwp_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('NPWP Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="npwp_lembaga" type="text"
                                            class="form-control @error('npwp_lembaga') is-invalid @enderror" name="npwp_lembaga"
                                            value="{{ $anggota->lembaga()->first()->npwp()->first()->npwp }}" autocomplete="name"
                                            autofocus>
            
                                        @error('npwp_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="email_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Email Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="email_lembaga" type="text" readonly
                                            class="form-control @error('email_lembaga') is-invalid @enderror" name="email_lembaga"
                                            value="{{ $anggota->email }}" autocomplete="name"
                                            autofocus>
            
                                        @error('email_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="no_hp_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Nomor HP / Telepon Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    +62
                                                </div>
                                            </div>
                                            <input id="no_hp_lembaga" type="text"
                                                class="form-control currency @error('no_hp_lembaga') is-invalid @enderror" name="no_hp_lembaga"
                                                value="{{ $anggota->no_hp }}" autocomplete="name"
                                                autofocus>
                                        </div>
            
                                        @error('no_hp_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_wa_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Whatsapp Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    +62
                                                </div>
                                            </div>
                                            <input id="no_wa_lembaga" type="text"
                                                class="form-control @error('no_wa_lembaga') is-invalid @enderror" name="no_wa_lembaga"
                                                value="{{ $anggota->no_wa }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        
                                        @error('no_wa_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_fax_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Fax Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    +62
                                                </div>
                                            </div>
                                            <input id="no_fax_lembaga" type="text"
                                                class="form-control @error('no_fax_lembaga') is-invalid @enderror" name="no_fax_lembaga"
                                                value="{{ $anggota->no_fax }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        
                                        @error('no_fax_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="username_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Username Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="username_lembaga" type="text" readonly
                                                class="form-control @error('username_lembaga') is-invalid @enderror" name="username_lembaga"
                                                value="{{ $anggota->userlogin()->first()->username }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('username_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="password_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Password Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="password_lembaga" type="password_lembaga"
                                                class="form-control password @error('password_lembaga') is-invalid @enderror" name="password_lembaga"
                                                value="" autocomplete="name"
                                                autofocus>
                                            <div class="input-group-append">
                                                <div class="input-group-text check-password">
                                                    <span class="fas fa-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-muted">Isi jika ingin merubah password</span>
                                        
                                        @error('password_lembaga')
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
                @else
                <div class="card">
                    <div class="card-header">
                        <h4 class="title-card-pic">{{ __('Informasi Calon Anggota') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="nik" class="col-md-4 col-form-label text-md-end">{{ __('NIK')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nik" type="text"
                                            class="form-control @error('nik') is-invalid @enderror" name="nik"
                                            value="{{ $anggota->member()->first()->ktp()->first()->nik }}" autocomplete="name"
                                            autofocus>
                                        <p class="text-muted"><span class="count-nik">16</span> / 16</p>
            
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
                                            value="{{ $anggota->member()->first()->ktp()->first()->nama }}" autocomplete="name"
                                            autofocus>
            
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
                                        <select class="custom-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" id="jenis_kelamin">
                                            <option {{ $anggota->member()->first()->ktp()->first()->jenis_kelamin == 'pria' ? 'selected' : '' }} value="pria">Laki-Laki</option>
                                            <option {{ $anggota->member()->first()->ktp()->first()->jenis_kelamin == 'wanita' ? 'selected' : '' }} value="wanita">Perempuan</option>
                                        </select>
            
                                        @error('jenis_kelamin')
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
                                            value="{{ $anggota->email }}" autocomplete="name"
                                            autofocus>
            
                                        @error('email')
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
                                            value="{{ $anggota->member()->first()->ktp()->first()->tanggal_lahir }}" autocomplete="name"
                                            autofocus>
            
                                        @error('tanggal_lahir')
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
                                            value="{{ $anggota->member()->first()->ktp()->first()->tempat_lahir }}" autocomplete="name"
                                            autofocus>
            
                                        @error('tempat_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_hp" class="col-md-4 col-form-label text-md-end">{{ __('Nomor HP / Telepon')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    +62
                                                </div>
                                            </div>
                                            <input id="no_hp" type="text"
                                                class="form-control currency @error('no_hp') is-invalid @enderror" name="no_hp"
                                                value="{{ $anggota->no_hp }}" autocomplete="name"
                                                autofocus>
                                        </div>
            
                                        @error('no_hp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_wa" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Whatsapp')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    +62
                                                </div>
                                            </div>
                                            <input id="no_wa" type="text"
                                                class="form-control @error('no_wa') is-invalid @enderror" name="no_wa"
                                                value="{{ $anggota->no_wa }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        
                                        @error('no_wa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_fax" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Fax')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    +62
                                                </div>
                                            </div>
                                            <input id="no_fax" type="text"
                                                class="form-control @error('no_fax') is-invalid @enderror" name="no_fax"
                                                value="{{ $anggota->no_fax }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        
                                        @error('no_fax')
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
                                                value="{{ $anggota->userlogin()->first()->username }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="password" type="password"
                                                class="form-control password @error('password') is-invalid @enderror" name="password"
                                                value="{{ old("password") }}" autocomplete="name"
                                                autofocus>
                                            <div class="input-group-append">
                                                <div class="input-group-text check-password">
                                                    <span class="fas fa-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-muted">Isi jika ingin mengubuah password</span>
                                        
                                        @error('password')
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
                                            <input id="pekerjaan" type="text"
                                                class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan"
                                                value="{{ $anggota->member()->first()->informasi_keuangan()->first()->pekerjaan }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('pekerjaan')
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
                                            value="{{ $anggota->member()->first()->informasi_keuangan()->first()->npwp()->first()->npwp }}" autocomplete="name"
                                            autofocus>
            
                                        @error('npwp')
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
                                            <option {{ $anggota->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan == '0-1.000.000' ? 'selected' : '' }} value='0-1.000.000'>0-Rp. 1.000.000</option>
                                            <option {{ $anggota->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan == '1.000.001-10.000.000' ? 'selected' : '' }} value='1.000.001-10.000.000'>Rp. 1.000.001-Rp. 10.000.000</option>
                                            <option {{ $anggota->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan == '10.000.001-50.000.000' ? 'selected' : '' }} value='10.000.001-50.000.000'>Rp. 10.000.001-Rp. 50.000.000</option>
                                            <option {{ $anggota->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan == '50.000.001-100.000.000' ? 'selected' : '' }} value='50.000.001-100.000.000'>Rp. 50.000.001-Rp. 100.000.000</option>
                                            <option {{ $anggota->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan == 'Diatas 100.000.000' ? 'selected' : '' }} value='Diatas 100.000.000'>Diatas Rp. 100.000.000</option>
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
                                            <input id="kekayaan_bersih" type="text"
                                                class="form-control @error('kekayaan_bersih') is-invalid @enderror" name="kekayaan_bersih"
                                                value="{{ $anggota->member()->first()->informasi_keuangan()->first()->kekayaan_bersih }}" autocomplete="name"
                                                autofocus>
                                        
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
                                            <input id="kekayaan_lancar" type="text"
                                                class="form-control @error('kekayaan_lancar') is-invalid @enderror" name="kekayaan_lancar"
                                                value="{{ $anggota->member()->first()->informasi_keuangan()->first()->kekayaan_lancar }}" autocomplete="name"
                                                autofocus>
                                        
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
                                        <select class="custom-select @error('sumber_dana') is-invalid @enderror" name="sumber_dana" id="sumber_dana">
                                            <option {{ $anggota->member()->first()->informasi_keuangan()->first()->sumber_dana == 'Milik Sendiri' ? 'selected' : '' }} value='Milik Sendiri'>Milik Sendiri</option>
                                            <option {{ $anggota->member()->first()->informasi_keuangan()->first()->sumber_dana == 'Orang Tua' ? 'selected' : '' }} value='Orang Tua'>Orang Tua</option>
                                            <option {{ $anggota->member()->first()->informasi_keuangan()->first()->sumber_dana == 'Investasi' ? 'selected' : '' }} value='Investasi'>Investasi</option>
                                            <option {{ $anggota->member()->first()->informasi_keuangan()->first()->sumber_dana == 'Tabungan Hari Tua' ? 'selected' : '' }} value='Tabungan Hari Tua'>Tabungan Hari Tua</option>
                                            <option {{ $anggota->member()->first()->informasi_keuangan()->first()->sumber_dana == 'Lainnya' ? 'selected' : '' }} value='Lainnya'>Lainnya</option>
                                        </select>
                                        
                                        @error('sumber_dana')
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
                                        <a type="button" href="{{ route('master.anggota.list.show', $anggota->informasi_akun_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <button type="submit" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Simpan</button>
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


