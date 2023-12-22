@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jenis Perdagangan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis') }}">Jenis</a></div>
        <div class="breadcrumb-item">Jenis Perdagangan</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Jenis Perdagangan</h2>
    <p class="section-lead">
        Kelola Jenis Perdagangan.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Jenis Perdagangan') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('konfigurasi.jenis.perdagangan.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-jenis-perdagangan">
                            <thead>
                                <tr>
                                    <th>Id Jenis Perdagangan</th>
                                    <th>Nama Jenis Perdagangan</th>
                                    <th>Status</th>
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
