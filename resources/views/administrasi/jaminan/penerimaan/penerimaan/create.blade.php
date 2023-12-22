@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Jaminan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Penerimaan Jaminan</h2>
    <p class="section-lead">
        Tambahkan data Penerimaan Jaminan.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('administrasi.jaminan.penerimaan.store') }}" method="post" enctype="multipart/form-data">@csrf
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Penerimaan Jaminan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('informasi_akun_id') is-invalid @enderror" @if(count($informasiAkun) == 0) disabled @endif  name="informasi_akun_id" id="informasi_akun_id">
                                            @foreach ($informasiAkun as $jt)
                                            <option value="{{ $jt->informasi_akun_id }}">{{ $jt->nama . ' ('. $jt->nik .')' }}</option>
                                            @endforeach
                                        </select>

                                        @error('informasi_akun_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i> </span>
                                            </div>
                                            <input id="tanggal" type="date"
                                                class="form-control" name="tanggal"
                                                value="{{ is_null(old("tanggal")) ? date('Y-m-d') : old("tanggal") }}" autocomplete="name"
                                                autofocus>
                                        </div>
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.index') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
