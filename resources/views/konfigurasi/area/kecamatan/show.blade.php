@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Kecamatan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area') }}">Area</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi') }}">Provinsi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.show', $provinsi->provinsi_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.kabupaten', $provinsi->provinsi_id) }}">Kabupaten</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.kabupaten.show', [$provinsi->provinsi_id, $kabupaten->kabupaten_id]) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.kabupaten.kecamatan', [$provinsi->provinsi_id, $kabupaten->kabupaten_id]) }}">Kecamatan</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Kecamatan</h2>
    <p class="section-lead">
        Detail data Kecamatan anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Kecamatan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center reg-in">
                                <label for="nama_kecamatan" class="col-md-4 col-form-label text-md-end">{{ __('Nama Kecamatan')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                        </div> 
                                        <input id="nama_kecamatan" type="text" readonly
                                            class="form-control" name="nama_kecamatan"
                                            value="{{ $kecamatan->nama_kecamatan }}" />
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
                                        <a type="button" href="{{ route('konfigurasi.area.provinsi.kabupaten.kecamatan', [$provinsi->provinsi_id, $kabupaten->kabupaten_id]) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('konfigurasi.area.provinsi.kabupaten.kecamatan.desa', [$provinsi->provinsi_id, $kabupaten->kabupaten_id, $kecamatan->kecamatan_id]) }}" class="btn btn-info mr-2"><i class="fas fa-street-view"></i> Desa</a>
                                        <a type="button" href="{{ route('konfigurasi.area.provinsi.kabupaten.kecamatan.edit', [$provinsi->provinsi_id, $kabupaten->kabupaten_id, $kecamatan->kecamatan_id]) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('konfigurasi.area.provinsi.kabupaten.kecamatan.destroy', [$provinsi->provinsi_id, $kabupaten->kabupaten_id, $kecamatan->kecamatan_id]) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Kecamatan akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                        </form>
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

