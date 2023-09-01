@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Verifikasi Calon Anggota</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.verifikasi') }}">Verifikasi Calon Anggota</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Verifikasi Calon Anggota</h2>
    <p class="section-lead">
        Detail data Verifikasi Calon Anggota anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Jenis Perseorangan') }}</h4>
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
                                            @if($calon->lembaga()->count() > 0)
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

            @if($calon->lembaga()->count() > 0)
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
                                    <input id="nama_lembaga" type="text" readonly
                                        class="form-control" name="nama_lembaga"
                                        value="{{ $calon->lembaga()->first()->nama_lembaga }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="bidang_usaha" class="col-md-4 col-form-label text-md-end">{{ __('Bidang Usaha')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="bidang_usaha" type="text" readonly
                                        class="form-control" name="bidang_usaha"
                                        value="{{ $calon->lembaga()->first()->bidang_usaha }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="npwp_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('NPWP Lembaga')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="npwp_lembaga" type="text" readonly
                                        class="form-control" name="npwp_lembaga"
                                        value="{{ is_null($calon->lembaga()->first()->npwp()) ? 'Belum ada NPWP' : $calon->lembaga()->first()->npwp()->first()->npwp }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="email_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Email Lembaga')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="email_lembaga" type="text" readonly
                                        class="form-control" name="email_lembaga"
                                        value="{{ $calon->email }}" autocomplete="name"
                                        autofocus>
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
                                        <input id="no_hp_lembaga" type="text" readonly
                                            class="form-control currency " name="no_hp_lembaga"
                                            value="{{ $calon->no_hp }}" autocomplete="name"
                                            autofocus>
                                    </div>
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
                                        <input id="no_wa_lembaga" type="text" readonly
                                            class="form-control " name="no_wa_lembaga"
                                            value="{{ $calon->no_wa }}" autocomplete="name"
                                            autofocus>
                                    </div>
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
                                        <input id="no_fax_lembaga" type="text" readonly
                                            class="form-control" name="no_fax_lembaga"
                                            value="{{ $calon->no_fax }}" autocomplete="name"
                                            autofocus>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="username_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Username Lembaga')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="username_lembaga" type="text" readonly
                                            class="form-control " name="username_lembaga"
                                            value="{{ $calon->userlogin()->first()->username }}" autocomplete="name"
                                            autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card lembaga">
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
                                    <input id="desa_lembaga" type="text" readonly
                                        class="form-control" name="desa_lembaga"
                                        value="{{ !is_null($calon->rekening_bank()->first()->bank()->first()) ? $calon->rekening_bank()->first()->bank()->first()->nama_bank : "Belum Dipilih" }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_rekening_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening Lembaga')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="nomor_rekening_lembaga" type="text" readonly
                                            class="form-control" name="nomor_rekening_lembaga"
                                            value="{{ $calon->rekening_bank()->first()->nomor_rekening }}" autocomplete="name"
                                            autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_pemilik_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pemilik Rekening Lembaga')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="nama_pemilik_lembaga" type="text" readonly
                                            class="form-control" name="nama_pemilik_lembaga"
                                            value="{{ $calon->rekening_bank()->first()->nama_pemilik }}" autocomplete="name" autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="cabang_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Cabang Lembaga')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="cabang_lembaga" type="text" readonly
                                        class="form-control" name="cabang_lembaga"
                                        value="{{ $calon->rekening_bank()->first()->cabang }}" autocomplete="name" autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="mata_uang_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Mata Uang Lembaga')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="desa_lembaga" type="text" readonly class="form-control" name="desa_lembaga" value="{{ $calon->rekening_bank()->first()->mata_uang }}" autocomplete="name" autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card lembaga">
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
                                    @if($calon->dokumen_member()->where('jenis_dokumen_id', $d->jenis_dokumen_id)->count() > 0)
                                    <img src="{{ asset('storage/dokumen_member_lembaga/' . $calon->dokumen_member()->where('jenis_dokumen_id', $d->jenis_dokumen_id)->first()->nama_file) }}" alt="{{ $d->nama_jenis }}" class="img img-thumbnail" id="{{ $d->nama_jenis }}_lembaga_show_lembaga" />
                                    @else 
                                    <p>Tidak ada Dokumen {{ $d->nama_jenis }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
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
                                        class="form-control" name="nik" readonly
                                        value="{{ $calon->member()->first()->ktp()->first()->nik }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nama" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nama" type="text" readonly
                                        class="form-control" name="nama"
                                        value="{{ $calon->member()->first()->ktp()->first()->nama }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_kelamin" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Kelamin')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="jenis_kelamin" type="text" readonly class="form-control" name="jenis_kelamin" value="{{ $calon->member()->first()->ktp()->first()->jenis_kelamin }}" autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="npwp" class="col-md-4 col-form-label text-md-end">{{ __('NPWP')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="npwp" type="text" readonly
                                        class="form-control @error('npwp') is-invalid @enderror" name="npwp" value="{{ is_null($calon->member()->first()->informasi_keuangan()->first()->npwp()) ? "Belum ada NPWP" : $calon->member()->first()->informasi_keuangan()->first()->npwp()->first()->npwp }}" autocomplete="name" autofocus>
        
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
                                    <input id="email" type="text" readonly
                                        class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $calon->email }}" autocomplete="name" autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_lahir" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Lahir')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="tanggal_lahir" type="date" readonly
                                        class="form-control" name="tanggal_lahir"
                                        value="{{ $calon->member()->first()->ktp()->first()->tanggal_lahir }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tempat_lahir" class="col-md-4 col-form-label text-md-end">{{ __('Tempat Lahir')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="tempat_lahir" type="text" readonly
                                        class="form-control" name="tempat_lahir"
                                        value="{{ $calon->member()->first()->ktp()->first()->tempat_lahir }}" autocomplete="name"
                                        autofocus>
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
                                        <input id="no_hp" type="text" readonly
                                            class="form-control currency" name="no_hp"
                                            value="{{ $calon->no_hp }}" autocomplete="name"
                                            autofocus>
                                    </div>
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
                                        <input id="no_wa" type="text" readonly
                                            class="form-control" name="no_wa"
                                            value="{{ $calon->no_wa }}" autocomplete="name"
                                            autofocus>
                                    </div>
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
                                            class="form-control" name="no_fax" readonly
                                            value="{{ $calon->no_fax }}" autocomplete="name"
                                            autofocus>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="username" type="text"
                                            class="form-control" name="username" readonly
                                            value="{{ $calon->userlogin()->first()->username }}" autocomplete="name"
                                            autofocus>
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
                                        <input id="pekerjaan" type="text" readonly
                                            class="form-control" name="pekerjaan"
                                            value="{{ $calon->member()->first()->informasi_keuangan()->first()->pekerjaan }}" autocomplete="name"
                                            autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="pendapatan_tahunan" class="col-md-4 col-form-label text-md-end">{{ __('Pendapatan Tahunan')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" readonly name="username" value="{{ $calon->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan }}" autocomplete="name" autofocus>
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
                                        <input id="kekayaan_bersih" type="text" readonly class="form-control thousand-style" name="kekayaan_bersih" value="{{ $calon->member()->first()->informasi_keuangan()->first()->kekayaan_bersih }}" autocomplete="name" autofocus>
                                    </div>
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
                                            <input id="kekayaan_lancar" type="text" readonly
                                                class="form-control thousand-style" name="kekayaan_lancar"
                                                value="{{ $calon->member()->first()->informasi_keuangan()->first()->kekayaan_lancar }}" autocomplete="name"
                                                autofocus>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="sumber_dana" class="col-md-4 col-form-label text-md-end">{{ __('Sumber Dana')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" readonly name="username" value="{{ $calon->member()->first()->informasi_keuangan()->first()->sumber_dana }}" autocomplete="name" autofocus>
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
                                    <input id="username" type="text" class="form-control" readonly name="username" value="{{ !is_null($calon->rekening_bank()->first()->bank()->first()) ? $calon->rekening_bank()->first()->bank()->first()->nama_bank : "Belum Dipilih" }}" autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_rekening" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="nomor_rekening" type="text" readonly class="form-control" name="nomor_rekening" value="{{ $calon->rekening_bank()->first()->nomor_rekening }}" autocomplete="name" autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_pemilik" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pemilik Rekening')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="nama_pemilik" type="text" readonly class="form-control" name="nama_pemilik" value="{{ $calon->rekening_bank()->first()->nama_pemilik }}" autocomplete="name" autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="cabang" class="col-md-4 col-form-label text-md-end">{{ __('Cabang')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="cabang" type="text" readonly
                                            class="form-control" name="cabang" value="{{ $calon->rekening_bank()->first()->cabang }}" autocomplete="name" autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Mata Uang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" readonly name="username" value="{{ $calon->rekening_bank()->first()->mata_uang }}" autocomplete="name" autofocus>
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
                                    @if($calon->dokumen_member()->where('jenis_dokumen_id', $d->jenis_dokumen_id)->count() > 0)
                                    <img src="{{ asset('storage/dokumen_member/'. $calon->dokumen_member()->where('jenis_dokumen_id', $d->jenis_dokumen_id)->first()->nama_file) }}" alt="{{ $d->nama_jenis }}" class="img img-thumbnail" id="{{ $d->nama_jenis }}_show" />
                                    @else
                                    <p>Tidak ada Dokumen {{ $d->nama_jenis }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Alamat') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <div class="table-responsive">
                                    <table class="table table-hover table-stripped">
                                        <thead>
                                            <tr>
                                                <th>Provinsi</th>
                                                <th>Kabupaten</th>
                                                <th>Kecamatan</th>
                                                <th>Desa</th>
                                                <th>Kode Pos</th>
                                                <th>Alamat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($calon->area_member()->get() as $area)
                                            <tr>
                                                <td>{{ $area->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->nama_provinsi }}</td>
                                                <td>{{ $area->desa()->first()->kecamatan()->first()->kabupaten()->first()->nama_kabupaten }}</td>
                                                <td>{{ $area->desa()->first()->kecamatan()->first()->nama_kecamatan }}</td>
                                                <td>{{ $area->desa()->first()->nama_desa }}</td>
                                                <td>{{ $area->kode_pos }}</td>
                                                <td>{{ $area->alamat }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('master.anggota.verifikasi.store', $calon->informasi_akun_id) }}" method="post"> @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Verifikasi') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_verifikasi" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Verifikasi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="tanggal_verifikasi" type="date" {{ !is_null($calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()) ? 'readonly' : '' }}
                                        class="form-control @error('tanggal_verifikasi') is-invalid @enderror" name="tanggal_verifikasi"
                                        value="{{ !is_null($calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()) ? explode(' ', $calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()->tanggal_verifikasi)['0'] : date('Y-m-d') }}" autocomplete="name"
                                        autofocus>

                                    @error('tanggal_verifikasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="is_agree" class="col-md-4 col-form-label text-md-end">{{ __('Aksi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('is_agree') is-invalid @enderror" name="is_agree" id="is_agree" {{ !is_null($calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()) ? 'disabled' : '' }}>
                                            <option {{ (!is_null($calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()) ? $calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()->is_agree : old('is_agree')) === true ? 'selected' : '' }} value="true">Setuju</option>
                                            <option {{ (!is_null($calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()) ? $calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()->is_agree : old('is_agree')) === false ? 'selected' : '' }} value="false">Tidak Setuju</option>
                                        </select>

                                    @error('is_agree')
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
                                        <textarea id="keterangan" {{ !is_null($calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()) ? 'readonly' : '' }} class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" cols="30" rows="10">{{ !is_null($calon->verified_log()->where('jenis_verifikasi_id',$jenisVerifikasi->jenis_verifikasi_id)->first()) ? $calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()->keterangan : old('keterangan') }}</textarea>
        
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
                        <h4>{{ __('Pilihan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                        <a type="button" href="{{ route('master.anggota.verifikasi') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        @if(is_null($calon->verified_log()->where('jenis_verifikasi_id', $jenisVerifikasi->jenis_verifikasi_id)->first()))
                                        <button type="submit" class="btn mx-2 btn-success"><i class="fas fa-check"></i> Verifikasi</a>
                                        @endif
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

