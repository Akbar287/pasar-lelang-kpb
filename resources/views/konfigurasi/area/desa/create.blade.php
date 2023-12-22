@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Desa</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area') }}">Area</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi') }}">Provinsi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.show', $provinsi->provinsi_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.kabupaten', $provinsi->provinsi_id) }}">Kabupaten</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.kabupaten.show', [$provinsi->provinsi_id, $kabupaten->kabupaten_id]) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.kabupaten.kecamatan', [$provinsi->provinsi_id, $kabupaten->kabupaten_id]) }}">Kecamatan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.kabupaten.kecamatan.show', [$provinsi->provinsi_id, $kabupaten->kabupaten_id, $kecamatan->kecamatan_id]) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.kabupaten.kecamatan.desa', [$provinsi->provinsi_id, $kabupaten->kabupaten_id, $kecamatan->kecamatan_id]) }}">Desa</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Desa</h2>
    <p class="section-lead">
        Tambahkan data Desa.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('konfigurasi.area.provinsi.kabupaten.kecamatan.desa.store', [$provinsi->provinsi_id, $kabupaten->kabupaten_id, $kecamatan->kecamatan_id]) }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Desa') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="nama_desa" class="col-md-4 col-form-label text-md-end">{{ __('Nama Desa')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-street-view"></i></span>
                                            </div>
                                            <input id="nama_desa" type="text"
                                                class="form-control @error('nama_desa') is-invalid @enderror" name="nama_desa"
                                                value="{{ old("nama_desa") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('nama_desa')
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
                                        <a type="button" href="{{ route('konfigurasi.area.provinsi.kabupaten.kecamatan.desa', [$provinsi->provinsi_id, $kabupaten->kabupaten_id, $kecamatan->kecamatan_id]) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
