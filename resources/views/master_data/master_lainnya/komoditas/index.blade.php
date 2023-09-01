@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Komoditas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lainnya</a></div>
        <div class="breadcrumb-item">Komoditas</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Komoditas</h2>
    <p class="section-lead">
        Kelola Komoditas.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Komoditas') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.lain.komoditas.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-komoditas">
                            <thead>
                                <tr>
                                    <th>Id Komoditas</th>
                                    <th>Nama Komoditas</th>
                                    <th>Satuan ukuran</th>
                                    <th>Inisiasi</th>
                                    <th>Kadaluarsa</th>
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
