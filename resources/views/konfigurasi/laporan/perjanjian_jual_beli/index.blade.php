@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Perjanjian Jual Beli</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.laporan') }}">Laporan</a></div>
        <div class="breadcrumb-item">Perjanjian Jual Beli</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Perjanjian Jual Beli</h2>
    <p class="section-lead">
        Kelola Perjanjian Jual Beli.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Perjanjian Jual Beli') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('konfigurasi.laporan.perjanjian_jual_beli.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-laporan-perjanjian">
                            <thead>
                                <tr>
                                    <th>Id Pasal</th>
                                    <th>Pasal</th>
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
