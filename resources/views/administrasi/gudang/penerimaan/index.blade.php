@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Gudang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang') }}">Gudang</a></div>
        <div class="breadcrumb-item">Penerimaan</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Penerimaan Gudang</h2>
    <p class="section-lead">
        Kelola Gudang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Penerimaan Gudang') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('administrasi.gudang.penerimaan.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-gudang-penerimaan">
                            <thead>
                                <tr>
                                    <th>Transaksi Id</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Registrasi</th>
                                    <th>Gudang</th>
                                    <th>Anggota</th>
                                    <th>Komoditas</th>
                                    <th>Nilai</th>
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
