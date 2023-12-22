@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jaminan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item">Verifikasi</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Jaminan</h2>
    <p class="section-lead">
        Kelola Jaminan.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Verifikasi Jaminan') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('administrasi.jaminan.pengeluaran.verifikasi.index_ditolak') }}" class="btn btn-danger">
                            Verifikasi Ditolak
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-jaminan-pengeluaran-verifikasi">
                            <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
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
