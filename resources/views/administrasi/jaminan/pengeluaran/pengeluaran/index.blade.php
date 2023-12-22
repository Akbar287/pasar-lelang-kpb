@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Pengeluaran Jaminan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item">Pengeluaran</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Pengeluaran Jaminan</h2>
    <p class="section-lead">
        Kelola Pengeluaran Jaminan.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Pengeluaran Jaminan') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('administrasi.jaminan.pengeluaran.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-jaminan-pengeluaran">
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
