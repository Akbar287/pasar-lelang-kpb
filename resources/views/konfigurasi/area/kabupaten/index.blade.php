@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Kabupaten</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area') }}">Area</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi') }}">Provinsi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area.provinsi.show', $provinsi->provinsi_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Kabupaten</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Kabupaten</h2>
    <p class="section-lead">
        Kelola Kabupaten.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Kabupaten') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('konfigurasi.area.provinsi.kabupaten.create', $provinsi->provinsi_id) }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-kabupaten">
                            <thead>
                                <tr>
                                    <th>Id Kabupaten</th>
                                    <th>Nama Kabupaten</th>
                                    <th>Kecamatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
