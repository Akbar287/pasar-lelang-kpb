@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Daftar Anggota</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list') }}">Daftar Anggota</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Daftar Anggota</h2>
    <p class="section-lead">
        Detail data Daftar Anggota anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
        <div class="card">
                <div class="card-header">
                    <h4>{{ __('Jenis Keanggotaan') }}</h4>
                    <div class="card-header-action">
                        @if(!is_null($anggota->member()->first()))
                            @if($anggota->member()->first()->status_member()->first()->nama_status == 'Aktif')
                            <div class="badge badge-success">{{ $anggota->member()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->member()->first()->status_member()->first()->nama_status == 'Calon Anggota')
                            <div class="badge badge-warning">{{ $anggota->member()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->member()->first()->status_member()->first()->nama_status == 'Suspend')
                            <div class="badge badge-danger">{{ $anggota->member()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->member()->first()->status_member()->first()->nama_status == 'Tidak Aktif')
                            <div class="badge badge-dark">{{ $anggota->member()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                        @else
                            @if($anggota->lembaga()->first()->status_member()->first()->nama_status == 'Aktif')
                            <div class="badge badge-success">{{ $anggota->lembaga()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->lembaga()->first()->status_member()->first()->nama_status == 'Calon Anggota')
                            <div class="badge badge-warning">{{ $anggota->lembaga()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->lembaga()->first()->status_member()->first()->nama_status == 'Suspend')
                            <div class="badge badge-danger">{{ $anggota->lembaga()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->lembaga()->first()->status_member()->first()->nama_status == 'Tidak Aktif')
                            <div class="badge badge-dark">{{ $anggota->lembaga()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                        @endif
                    </div>
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
                                    <input id="nama_lembaga" type="text" readonly
                                        class="form-control" name="nama_lembaga"
                                        value="{{ $anggota->lembaga()->first()->nama_lembaga }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="bidang_usaha" class="col-md-4 col-form-label text-md-end">{{ __('Bidang Usaha')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="bidang_usaha" type="text" readonly
                                        class="form-control" name="bidang_usaha"
                                        value="{{ $anggota->lembaga()->first()->bidang_usaha }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="npwp_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('NPWP Lembaga')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="npwp_lembaga" type="text" readonly
                                        class="form-control" name="npwp_lembaga"
                                        value="{{ is_null($anggota->lembaga()->first()->npwp()) ? 'Belum ada NPWP' : $anggota->lembaga()->first()->npwp()->first()->npwp }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="email_lembaga" class="col-md-4 col-form-label text-md-end">{{ __('Email Lembaga')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="email_lembaga" type="text" readonly
                                        class="form-control" name="email_lembaga"
                                        value="{{ $anggota->email }}" autocomplete="name"
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
                                            class="form-control " name="no_hp_lembaga"
                                            value="{{ $anggota->no_hp }}" autocomplete="name"
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
                                            value="{{ $anggota->no_wa }}" autocomplete="name"
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
                                            value="{{ $anggota->no_fax }}" autocomplete="name"
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
                                            value="{{ $anggota->userlogin()->first()->username }}" autocomplete="name"
                                            autofocus>
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
                                        class="form-control" name="nik" readonly
                                        value="{{ $anggota->member()->first()->ktp()->first()->nik }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nama" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nama" type="text" readonly
                                        class="form-control" name="nama"
                                        value="{{ $anggota->member()->first()->ktp()->first()->nama }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_kelamin" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Kelamin')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jenis_kelamin" type="text" readonly class="form-control" name="jenis_kelamin" value="{{ $anggota->member()->first()->ktp()->first()->jenis_kelamin }}" autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" readonly
                                        class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $anggota->email }}" autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_lahir" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Lahir')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="tanggal_lahir" type="date" readonly
                                        class="form-control" name="tanggal_lahir"
                                        value="{{ $anggota->member()->first()->ktp()->first()->tanggal_lahir }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tempat_lahir" class="col-md-4 col-form-label text-md-end">{{ __('Tempat Lahir')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="tempat_lahir" type="text" readonly
                                        class="form-control" name="tempat_lahir"
                                        value="{{ $anggota->member()->first()->ktp()->first()->tempat_lahir }}" autocomplete="name"
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
                                            class="form-control" name="no_hp"
                                            value="{{ $anggota->no_hp }}" autocomplete="name"
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
                                            value="{{ $anggota->no_wa }}" autocomplete="name"
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
                                            value="{{ $anggota->no_fax }}" autocomplete="name"
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
                                            value="{{ $anggota->userlogin()->first()->username }}" autocomplete="name"
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
                                            value="{{ $anggota->member()->first()->informasi_keuangan()->first()->pekerjaan }}" autocomplete="name"
                                            autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="npwp" class="col-md-4 col-form-label text-md-end">{{ __('NPWP')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="npwp" type="text" readonly
                                        class="form-control @error('npwp') is-invalid @enderror" name="npwp" value="{{ is_null($anggota->member()->first()->informasi_keuangan()->first()->npwp()) ? "Belum ada NPWP" : $anggota->member()->first()->informasi_keuangan()->first()->npwp()->first()->npwp }}" autocomplete="name" autofocus>

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
                                    <input id="username" type="text" class="form-control" readonly name="username" value="{{ $anggota->member()->first()->informasi_keuangan()->first()->pendapatan_tahunan }}" autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="kekayaan_bersih" class="col-md-4 col-form-label text-md-end">{{ __('Kekayaan Bersih')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="kekayaan_bersih" type="text" readonly class="form-control" name="kekayaan_bersih" value="Rp. {{ number_format($anggota->member()->first()->informasi_keuangan()->first()->kekayaan_bersih, 2, ".", ",") }}" autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="kekayaan_lancar" class="col-md-4 col-form-label text-md-end">{{ __('Kekayaan Lancar')
                                    }}</label>

                                <div class="col-md-6">
                                        <input id="kekayaan_lancar" type="text" readonly
                                            class="form-control" name="kekayaan_lancar"
                                            value="Rp. {{ number_format($anggota->member()->first()->informasi_keuangan()->first()->kekayaan_lancar, 2, ".", ",") }}" autocomplete="name"
                                            autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="sumber_dana" class="col-md-4 col-form-label text-md-end">{{ __('Sumber Dana')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" readonly name="username" value="{{ $anggota->member()->first()->informasi_keuangan()->first()->sumber_dana }}" autocomplete="name" autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(!is_null($anggota->jaminan()->first()))
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Jaminan Lelang') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="total_saldo_jaminan" class="col-md-4 col-form-label text-md-end">{{ __('Total Saldo Jaminan')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-6">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp
                                            </div>
                                        </div>
                                        <input id="total_saldo_jaminan" type="text" readonly
                                            class="form-control thousand-style" name="total_saldo_jaminan"
                                            value="{{ !is_null($anggota->jaminan()->first()->total_saldo_jaminan) ? number_format($anggota->jaminan()->first()->total_saldo_jaminan, 0, ".", ",") : 0 }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="saldo_teralokasi" class="col-md-4 col-form-label text-md-end">{{ __('Saldo Jaminan Terpakai')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-6">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp
                                            </div>
                                        </div>
                                        <input id="saldo_teralokasi" type="text" readonly
                                            class="form-control thousand-style" name="saldo_teralokasi"
                                            value="{{ !is_null($anggota->jaminan()->first()->saldo_teralokasi) ? number_format($anggota->jaminan()->first()->saldo_teralokasi, 0, ".", ",") : 0 }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="saldo_tersedia" class="col-md-4 col-form-label text-md-end">{{ __('Saldo Jaminan Tersedia')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-6">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp
                                            </div>
                                        </div>
                                        <input id="saldo_tersedia" type="text" readonly
                                            class="form-control thousand-style" name="saldo_tersedia"
                                            value="{{ !is_null($anggota->jaminan()->first()->saldo_tersedia) ? number_format($anggota->jaminan()->first()->saldo_tersedia, 0, ".", ",") : 0 }}" />
                                    </div>
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
                                <div class="col-md-10  d-flex align-items-end">
                                    <a type="button" href="{{ route('master.anggota.list') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('master.anggota.list.rekening.index', $anggota->informasi_akun_id) }}" class="btn btn-info mr-2"><i class="fas fa-credit-card"></i> Rekening Bank</a>
                                    <a type="button" href="{{ route('master.anggota.list.area.index', $anggota->informasi_akun_id) }}" class="btn btn-warning mr-2"><i class="fas fa-home"></i> Alamat</a>
                                    <a type="button" href="{{ route('master.anggota.list.dokumen.index', $anggota->informasi_akun_id) }}" class="btn btn-primary mr-2"><i class="fas fa-file"></i> Dokumen</a>
                                    <a type="button" href="{{ route('master.anggota.list.edit', $anggota->informasi_akun_id) }}" class="btn mr-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <a type="button" href="{{ route('master.anggota.list.suspend.index', $anggota->informasi_akun_id) }}" class="btn mr-2 btn-danger"><i class="fas fa-pen"></i> Suspend</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
