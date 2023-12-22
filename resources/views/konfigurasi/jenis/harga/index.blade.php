@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jenis Harga</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis') }}">Jenis</a></div>
        <div class="breadcrumb-item">Jenis Harga</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Jenis Harga</h2>
    <p class="section-lead">
        Kelola Jenis Harga.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Jenis Harga') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('konfigurasi.jenis.harga.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-jenis-harga">
                            <thead>
                                <tr>
                                    <th>Id Jenis Harga</th>
                                    <th>Nama Jenis Harga</th>
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
