@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Anggota KPB</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.kpb') }}">Anggota KPB</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Anggota KPB</h2>
    <p class="section-lead">
        Detail data Anggota KPB.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title-card-pic">{{ __('Informasi Anggota KPB') }}</h4>
                    <div class="card-header-action">
                        @if (is_null($calon->is_member_lelang))
                            <div class="badge badge-secondary">Belum Diatur</div>
                        @else
                            @if ($calon->is_member_lelang)
                                <div class="badge badge-success">Anggota Pasar Lelang</div>
                            @else
                                <div class="badge badge-danger">Diatur Sebagai Bukan Anggota</div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="nik" class="col-md-4 col-form-label text-md-end">{{ __('NIK')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nik" type="text"
                                        class="form-control {{is_null($calon->nik) || empty($calon->nik) || $calon->nik == 'null' ? 'is-invalid' : ''}}" name="nik" readonly
                                        value="{{ $calon->nik }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nama" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nama" type="text" readonly
                                        class="form-control {{is_null($calon->nama) || empty($calon->nama) || $calon->nama == 'null' ? 'is-invalid' : ''}}" name="nama"
                                        value="{{ $calon->nama }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_kelamin" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Kelamin')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jenis_kelamin" type="text" readonly class="form-control {{is_null($calon->jenis_kelamin) || empty($calon->jenis_kelamin) || $calon->jenis_kelamin == 'null' ? 'is-invalid' : ''}}" name="jenis_kelamin" value="{{ $calon->jenis_kelamin }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" readonly class="form-control  {{is_null($calon->email) || empty($calon->email) || $calon->email == 'null' ? 'is-invalid' : ''}}" name="email" value="{{ $calon->email }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_lahir" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Lahir')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="tanggal_lahir" type="date" readonly
                                        class="form-control {{is_null($calon->tanggal_lahir) || empty($calon->tanggal_lahir) || $calon->tanggal_lahir == 'null' ? 'is-invalid' : ''}}" name="tanggal_lahir" value="{{ $calon->tanggal_lahir }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tempat_lahir" class="col-md-4 col-form-label text-md-end">{{ __('Tempat Lahir')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="tempat_lahir" type="text" readonly
                                        class="form-control {{is_null($calon->tempat_lahir) || empty($calon->tempat_lahir) || $calon->tempat_lahir == 'null' ? 'is-invalid' : ''}}" name="tempat_lahir"
                                        value="{{ $calon->tempat_lahir }}" />
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
                                            class="form-control currency {{is_null($calon->no_hp) || empty($calon->no_hp) || $calon->no_hp == 'null' ? 'is-invalid' : ''}}" name="no_hp"
                                            value="{{ $calon->no_hp }}" >
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
                                            class="form-control {{is_null($calon->no_wa) || empty($calon->no_wa) || $calon->no_wa == 'null' ? 'is-invalid' : ''}}" name="no_wa"
                                            value="{{ $calon->no_wa }}" >
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="provinsi" class="col-md-4 col-form-label text-md-end">{{ __('Provinsi')
                                    }}</label>

                                <div class="col-md-6">
                                        <input id="provinsi" type="text"
                                            class="form-control {{is_null($calon->provinsi_id) || empty($calon->provinsi_id) || $calon->provinsi_id == 'null' ? 'is-invalid' : ''}}" name="provinsi" readonly
                                            value="{{ $opt['provinsi'] }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="kabupaten" class="col-md-4 col-form-label text-md-end">{{ __('Kabupaten')
                                    }}</label>

                                <div class="col-md-6">
                                        <input id="kabupaten" type="text"
                                            class="form-control {{is_null($calon->kabupaten_id) || empty($calon->kabupaten_id) || $calon->kabupaten_id == 'null' ? 'is-invalid' : ''}}" name="kabupaten" readonly
                                            value="{{ $opt['kabupaten'] }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="kecamatan" class="col-md-4 col-form-label text-md-end">{{ __('Kecamatan')
                                    }}</label>

                                <div class="col-md-6">
                                        <input id="kecamatan" type="text"
                                            class="form-control {{is_null($calon->kecamatan_id) || empty($calon->kecamatan_id) || $calon->kecamatan_id == 'null' ? 'is-invalid' : ''}}" name="kecamatan" readonly
                                            value="{{ $opt['kecamatan'] }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="desa" class="col-md-4 col-form-label text-md-end">{{ __('Desa')
                                    }}</label>

                                <div class="col-md-6">
                                        <input id="desa" type="text"
                                            class="form-control {{is_null($calon->desa_id) || empty($calon->desa_id) || $calon->desa_id == 'null' ? 'is-invalid' : ''}}" name="desa" readonly
                                            value="{{ $opt['desa'] }}" />
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
                            <div class="alert alert-warning">Terdapat Isian yang masih kosong. Disarankan untuk mendaftarkan ulang anggota ke aplikasi pasar lelang.</div>
                        <div class="col-md-12">
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-2 d-flex align-items-end">
                                    <a type="button" href="{{ route('master.anggota.kpb') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    @if(is_null($calon->is_member_lelang) || $calon->is_member_lelang == false)
                                    <form action="{{ route('master.anggota.kpb.edit', $calon->nik) }}" method="POST">@csrf @method('put')
                                        <input type="hidden" name="confirm" value="1" />
                                        <button type="submit" onclick="return confirm('Anggota ini ditandai sebagai Anggota Pasar Lelang KPB!\n Lanjutkan?')" title="Tandai Anggota" class="btn btn-success mr-2"><i class="fas fa-check"></i> Tandai Sebagai Anggota Lelang</button>
                                    </form>
                                    @endif
                                    @if(is_null($calon->is_member_lelang) || $calon->is_member_lelang == true)
                                    <form action="{{ route('master.anggota.kpb.edit', $calon->nik) }}" method="POST">@csrf @method('put')
                                        <input type="hidden" name="confirm" value="0" />
                                        <button type="submit" onclick="return confirm('Anggota ini ditandai sebagai Bukan Anggota!\n Lanjutkan?')" title="Tandai Anggota" class="btn btn-danger"><i class="fas fa-times"></i> Tandai Sebagai Bukan Anggota</button>
                                    </form>
                                    @endif
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

