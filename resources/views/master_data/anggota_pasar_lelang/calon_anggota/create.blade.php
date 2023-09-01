@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Calon Anggota</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.calon') }}">Calon Anggota</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Calon Anggota</h2>
    <p class="section-lead">
        Tambahkan data Calon Anggota anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('master.anggota.calon.store') }}" method="post" enctype="multipart/form-data">@csrf 

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Lembaga') }}</h4>
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
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="jenis_perseorangan" value="perseorangan" class="selectgroup-input" {{ old('jenis_perseorangan') == 'perseorangan' ? 'checked=""' : '' }}>
                                                    <span class="selectgroup-button">Perseorangan</span>
                                                </label>
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="jenis_perseorangan" value="lembaga" class="selectgroup-input" {{ old('jenis_perseorangan') == 'lembaga' ? 'checked=""' : '' }}>
                                                    <span class="selectgroup-button">Lembaga</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card lembaga d-none">
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
                                            value="{{ old("nama_lembaga") }}" autocomplete="name"
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
                                            value="{{ old("bidang_usaha") }}" autocomplete="name"
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
                                            value="{{ old("npwp_lembaga") }}" autocomplete="name"
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
                                        <input id="email_lembaga" type="text"
                                            class="form-control @error('email_lembaga') is-invalid @enderror" name="email_lembaga"
                                            value="{{ old("email_lembaga") }}" autocomplete="name"
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
                                                value="{{ old("no_hp_lembaga") }}" autocomplete="name"
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
                                                value="{{ old("no_wa_lembaga") }}" autocomplete="name"
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
                                                value="{{ old("no_fax_lembaga") }}" autocomplete="name"
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
                                            <input id="username_lembaga" type="text"
                                                class="form-control @error('username_lembaga') is-invalid @enderror" name="username_lembaga"
                                                value="{{ old("username_lembaga") }}" autocomplete="name"
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
                                                value="{{ old("password_lembaga") }}" autocomplete="name"
                                                autofocus>
                                            <div class="input-group-append">
                                                <div class="input-group-text check-password">
                                                    <span class="fas fa-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @error('password_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="provinsi_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Provinsi Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('provinsi_lembaga') is-invalid @enderror" name="provinsi_lembaga" id="provinsi_lembaga">
                                            <option value="0">Pilih Provinsi Lembaga</option>
                                            @foreach($provinsi as $prov)
                                            <option {{ old('provinsi_lembaga') == $prov->provinsi_id ? 'selected' : '' }} value="{{ $prov->provinsi_id }}">{{ $prov->nama_provinsi }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('provinsi_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kabupaten_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Kabupaten Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select disabled class="custom-select @error('kabupaten_lembaga') is-invalid @enderror" name="kabupaten_lembaga" id="kabupaten_lembaga">
                                        </select>
                                        
                                        @error('kabupaten_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kecamatan_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Kecamatan Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select disabled class="custom-select @error('kecamatan_lembaga') is-invalid @enderror" name="kecamatan_lembaga" id="kecamatan_lembaga">
                                        </select>
                                        
                                        @error('kecamatan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="desa_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Desa Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select disabled class="custom-select @error('desa_lembaga') is-invalid @enderror" name="desa_lembaga" id="desa_lembaga">
                                        </select>
                                        
                                        @error('desa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="alamat_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Alamat Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="alamat_lembaga" type="text"
                                                class="form-control @error('alamat_lembaga') is-invalid @enderror" name="alamat_lembaga"
                                                value="{{ old("alamat_lembaga") }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('alamat_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kode_pos_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Kode Pos Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="kode_pos_lembaga" type="text"
                                                class="form-control @error('kode_pos_lembaga') is-invalid @enderror" name="kode_pos_lembaga"
                                                value="{{ old("kode_pos_lembaga") }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('kode_pos_lembaga')
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

                <div class="card lembaga d-none">
                    <div class="card-header">
                        <h4>{{ __('Informasi Rekening Bank Lembaga') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_bank_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Bank Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('nama_bank_lembaga') is-invalid @enderror" name="nama_bank_lembaga" id="nama_bank_lembaga">
                                            @foreach($banks as $bank)
                                            <option {{ old('nama_bank_lembaga') == $bank->bank_id ? 'selected' : '' }} value='{{ $bank->bank_id }}'>{{ $bank->nama_bank }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('nama_bank_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_rekening_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="nomor_rekening_lembaga" type="text"
                                                class="form-control @error('nomor_rekening_lembaga') is-invalid @enderror" name="nomor_rekening_lembaga"
                                                value="{{ old("nomor_rekening_lembaga") }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('nomor_rekening_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_pemilik_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pemilik Rekening Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="nama_pemilik_lembaga" type="text"
                                                class="form-control @error('nama_pemilik_lembaga') is-invalid @enderror" name="nama_pemilik_lembaga"
                                                value="{{ old("nama_pemilik_lembaga") }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('nama_pemilik_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="cabang_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Cabang Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="cabang_lembaga" type="text"
                                                class="form-control @error('cabang_lembaga') is-invalid @enderror" name="cabang_lembaga"
                                                value="{{ old("cabang_lembaga") }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('cabang_lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="mata_uang_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Mata Uang Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('mata_uang_lembaga') is-invalid @enderror" name="mata_uang_lembaga" id="mata_uang_lembaga">
                                            <option {{ old('mata_uang_lembaga') == 'IDR' ? 'selected' : '' }} value='{{ 'IDR' }}'>IDR</option>
                                            <option {{ old('mata_uang_lembaga') == 'USD' ? 'selected' : '' }} value='{{ 'USD' }}'>USD</option>
                                        </select>
                                        
                                        @error('mata_uang_lembaga')
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

                <div class="card lembaga d-none">
                    <div class="card-header">
                        <h4>{{ __('Dokumen Anggota Lembaga') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($dokumen as $d)
                                <input type="hidden" name="jenis_file_lembaga[]" value="{{ $d->nama_jenis }}" />
                                <div class="row mb-3 justify-content-center">
                                    <label for="{{ $d->nama_jenis }}_lembaga" class="col-md-4 col-form-label text-md-end">{{ __($d->nama_jenis)
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input id="{{ $d->nama_jenis }}_lembaga" type="file"
                                                class="custom-file-input lembaga @error('{{ $d->nama_jenis }}') is-invalid @enderror" name="file_lembaga[]"
                                                value="{{ old($d->nama_jenis) }}">
                                            <label class="custom-file-label" for="{{ $d->nama_jenis }}_lembaga">Pilih file</label>
                                        </div>
                                        <img src="" alt="{{ $d->nama_jenis }}" class="img img-thumbnail d-none" id="{{ $d->nama_jenis }}_lembaga_show_lembaga" />

                                        @error("file_lembaga[]")
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="title-card-pic">{{ __('Informasi Calon Anggota') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center d-none lembaga-mandatory">
                                    <label for="jabatan" class="col-md-4 col-form-label text-md-end">{{ __('Jabatan di lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="jabatan" type="text"
                                            class="form-control @error('jabatan') is-invalid @enderror" name="jabatan"
                                            value="{{ old("jabatan") }}" autocomplete="name"
                                            autofocus>
            
                                        @error('jabatan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nik" class="col-md-4 col-form-label text-md-end">{{ __('NIK')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nik" type="text"
                                            class="form-control @error('nik') is-invalid @enderror" name="nik"
                                            value="{{ old("nik") }}" autocomplete="name"
                                            autofocus>
                                        <p class="text-muted"><span class="count-nik">0</span> / 16</p>
            
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
                                            value="{{ old("nama") }}" autocomplete="name"
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
                                            <option {{ old('jenis_kelamin') == 'pria' ? 'selected' : '' }} value="pria">Laki-Laki</option>
                                            <option {{ old('jenis_kelamin') == 'wanita' ? 'selected' : '' }} value="wanita">Perempuan</option>
                                        </select>
            
                                        @error('jenis_kelamin')
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
                                            value="{{ old("npwp") }}" autocomplete="name"
                                            autofocus>
            
                                        @error('npwp')
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
                                        <input id="email" type="text"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old("email") }}" autocomplete="name"
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
                                            value="{{ old("tanggal_lahir") }}" autocomplete="name"
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
                                            value="{{ old("tempat_lahir") }}" autocomplete="name"
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
                                                value="{{ old("no_hp") }}" autocomplete="name"
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
                                                value="{{ old("no_wa") }}" autocomplete="name"
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
                                                value="{{ old("no_fax") }}" autocomplete="name"
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
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                value="{{ old("username") }}" autocomplete="name"
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
                                        
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="provinsi" class="col-md-4 col-form-label text-md-end">{{ __('Provinsi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi">
                                            <option value="0">Pilih Provinsi</option>
                                            @foreach($provinsi as $prov)
                                            <option {{ old('provinsi') == $prov->provinsi_id ? 'selected' : '' }} value="{{ $prov->provinsi_id }}">{{ $prov->nama_provinsi }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('provinsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kabupaten" class="col-md-4 col-form-label text-md-end">{{ __('Kabupaten')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select disabled class="custom-select @error('kabupaten') is-invalid @enderror" name="kabupaten" id="kabupaten">
                                        </select>
                                        
                                        @error('kabupaten')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kecamatan" class="col-md-4 col-form-label text-md-end">{{ __('Kecamatan')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select disabled class="custom-select @error('kecamatan') is-invalid @enderror" name="kecamatan" id="kecamatan">
                                        </select>
                                        
                                        @error('kecamatan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="desa" class="col-md-4 col-form-label text-md-end">{{ __('Desa')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select disabled class="custom-select @error('desa') is-invalid @enderror" name="desa" id="desa">
                                        </select>
                                        
                                        @error('desa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="alamat" type="text"
                                                class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                                value="{{ old("alamat") }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kode_pos" class="col-md-4 col-form-label text-md-end">{{ __('Kode Pos')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="kode_pos" type="text"
                                                class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos"
                                                value="{{ old("kode_pos") }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('kode_pos')
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
                                                value="{{ old("pekerjaan") }}" autocomplete="name"
                                                autofocus>
                                        
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
                                            <option {{ old('pendapatan_tahunan') == '0-1.000.000' ? 'selected' : '' }} value='0-1.000.000'>0-Rp. 1.000.000</option>
                                            <option {{ old('pendapatan_tahunan') == '1.000.001-10.000.000' ? 'selected' : '' }} value='1.000.001-10.000.000'>Rp. 1.000.001-Rp. 10.000.000</option>
                                            <option {{ old('pendapatan_tahunan') == '10.000.001-50.000.000' ? 'selected' : '' }} value='10.000.001-50.000.000'>Rp. 10.000.001-Rp. 50.000.000</option>
                                            <option {{ old('pendapatan_tahunan') == '50.000.001-100.000.000' ? 'selected' : '' }} value='50.000.001-100.000.000'>Rp. 50.000.001-Rp. 100.000.000</option>
                                            <option {{ old('pendapatan_tahunan') == 'Diatas 100.000.000' ? 'selected' : '' }} value='Diatas 100.000.000'>Diatas Rp. 100.000.000</option>
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
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input id="kekayaan_bersih" type="text"
                                                class="form-control  thousand-style @error('kekayaan_bersih') is-invalid @enderror" name="kekayaan_bersih"
                                                value="{{ old("kekayaan_bersih") }}" autocomplete="name"
                                                autofocus>
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
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input id="kekayaan_lancar" type="text"
                                                class="form-control  thousand-style @error('kekayaan_lancar') is-invalid @enderror" name="kekayaan_lancar"
                                                value="{{ old("kekayaan_lancar") }}" autocomplete="name"
                                                autofocus>
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
                                        <select class="custom-select @error('sumber_dana') is-invalid @enderror" name="sumber_dana" id="sumber_dana">
                                            <option {{ old('sumber_dana') == 'Milik Sendiri' ? 'selected' : '' }} value='Milik Sendiri'>Milik Sendiri</option>
                                            <option {{ old('sumber_dana') == 'Orang Tua' ? 'selected' : '' }} value='Orang Tua'>Orang Tua</option>
                                            <option {{ old('sumber_dana') == 'Investasi' ? 'selected' : '' }} value='Investasi'>Investasi</option>
                                            <option {{ old('sumber_dana') == 'Tabungan Hari Tua' ? 'selected' : '' }} value='Tabungan Hari Tua'>Tabungan Hari Tua</option>
                                            <option {{ old('sumber_dana') == 'Lainnya' ? 'selected' : '' }} value='Lainnya'>Lainnya</option>
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

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Informasi Rekening Bank ') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_bank" class="col-md-4 col-form-label text-md-end">{{ __('Bank')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('nama_bank') is-invalid @enderror" name="nama_bank" id="nama_bank">
                                            @foreach($banks as $bank)
                                            <option {{ old('nama_bank') == $bank->bank_id ? 'selected' : '' }} value='{{ $bank->bank_id }}'>{{ $bank->nama_bank }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('nama_bank')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_rekening" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="nomor_rekening" type="text"
                                                class="form-control @error('nomor_rekening') is-invalid @enderror" name="nomor_rekening"
                                                value="{{ old("nomor_rekening") }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('nomor_rekening')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_pemilik" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pemilik Rekening')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="nama_pemilik" type="text"
                                                class="form-control @error('nama_pemilik') is-invalid @enderror" name="nama_pemilik"
                                                value="{{ old("nama_pemilik") }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('nama_pemilik')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="cabang" class="col-md-4 col-form-label text-md-end">{{ __('Cabang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="cabang" type="text"
                                                class="form-control @error('cabang') is-invalid @enderror" name="cabang"
                                                value="{{ old("cabang") }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('cabang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Mata Uang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('mata_uang') is-invalid @enderror" name="mata_uang" id="mata_uang">
                                            <option {{ old('mata_uang') == 'IDR' ? 'selected' : '' }} value='{{ 'IDR' }}'>IDR</option>
                                            <option {{ old('mata_uang') == 'USD' ? 'selected' : '' }} value='{{ 'USD' }}'>USD</option>
                                        </select>
                                        
                                        @error('mata_uang')
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
                        <h4>{{ __('Dokumen Anggota') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($dokumen as $d)
                                <input type="hidden" value="{{ $d->nama_jenis }}" name="jenis_file[]" />
                                <div class="row mb-3 justify-content-center">
                                    <label for="{{ $d->nama_jenis }}" class="col-md-4 col-form-label text-md-end">{{ __($d->nama_jenis)
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input id="{{ $d->nama_jenis }}" type="file" 
                                                class="custom-file-input @error('{{ $d->nama_jenis }}') is-invalid @enderror" name="file[]"
                                                value="{{ old($d->nama_jenis) }}">
                                            <label class="custom-file-label" for="{{ $d->nama_jenis }}">Pilih file</label>
                                        </div>
                                        <img src="" alt="{{ $d->nama_jenis }}" class="img img-thumbnail d-none" id="{{ $d->nama_jenis }}_show" />

                                        @error($d->nama_jenis)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Pilihan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                        <a type="button" href="{{ route('master.anggota.calon') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
