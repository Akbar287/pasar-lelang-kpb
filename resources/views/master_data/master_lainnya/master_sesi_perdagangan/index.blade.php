@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Master Sesi Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lainnya</a></div>
        <div class="breadcrumb-item">Master Sesi Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Master Sesi Lelang</h2>
    <p class="section-lead">
        Kelola Master Sesi Lelang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Master Sesi Lelang') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.lain.sesi.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sesi">
                            <thead>
                                <tr>
                                    <th>Id Sesi</th>
                                    <th>Nama</th>
                                    <th>Sesi</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Berakhir</th>
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
