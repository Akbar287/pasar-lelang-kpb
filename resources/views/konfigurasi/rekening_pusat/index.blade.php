@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Rekening Pusat</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item">Rekening Pusat</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Rekening Pusat</h2>
    <p class="section-lead">
        Kelola Rekening Pusat.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Rekening Pusat') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('konfigurasi.rekening_pusat.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-rekening-pusat">
                            <thead>
                                <tr>
                                    <th>Id Rekening Pusat</th>
                                    <th>Nama Bank</th>
                                    <th>Nomor Rekening</th>
                                    <th>Saldo</th>
                                    <th>Aktif</th>
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
