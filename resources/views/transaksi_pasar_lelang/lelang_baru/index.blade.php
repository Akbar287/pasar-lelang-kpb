@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Lelang Baru</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi') }}">Transaksi Pasar lelang</a></div>
        <div class="breadcrumb-item">Lelang Baru</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Lelang Baru</h2>
    <p class="section-lead">
        Kelola Lelang Baru.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Lelang Baru') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('transaksi.lelang_baru.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lelang-baru">
                            <thead>
                                <tr>
                                    <th>Id Lelang</th>
                                    <th>Nama</th>
                                    <th>Kontrak</th>
                                    <th>Nomor lelang</th>
                                    <th>Judul</th>
                                    <th>Harga Awal</th>
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
