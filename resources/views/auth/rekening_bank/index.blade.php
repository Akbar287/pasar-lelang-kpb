@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Rekening Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil') }}">Profil</a></div>
        <div class="breadcrumb-item">Rekening Bank</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Rekening Bank Saya</h2>
    <p class="section-lead">
        Kelola Rekening Bank.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Rekening Bank') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('home.profil.rekening_bank.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-rekening-bank-profil">
                            <thead>
                                <tr>
                                    <th>Nama Bank</th>
                                    <th>Nomor Rekening</th>
                                    <th>Saldo</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('home.profil') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
