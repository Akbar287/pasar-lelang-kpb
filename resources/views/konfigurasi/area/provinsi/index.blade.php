@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Provinsi</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.area') }}">Area</a></div>
        <div class="breadcrumb-item">Provinsi</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Provinsi</h2>
    <p class="section-lead">
        Kelola Provinsi.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Provinsi') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('konfigurasi.area.provinsi.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-provinsi">
                            <thead>
                                <tr>
                                    <th>Id Provinsi</th>
                                    <th>Nama Provinsi</th>
                                    <th>Kabupaten</th>
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
