@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Kas Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.kas_bank') }}">Kas Bank</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.kas_bank.verifikasi.index') }}">Verifikasi</a></div>
        <div class="breadcrumb-item">Ditolak</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Kas Bank</h2>
    <p class="section-lead">
        Kelola Kas Bank.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Kas Bank') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-kas_bank-verifikasi-tolak">
                            <thead>
                                <tr>
                                    <th>Id Keuangan</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Kurs Mata Uang</th>
                                    <th>Saldo</th>
                                    <th>Jumlah</th>
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
