@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Riwayat Event Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event') }}">Event Lelang</a></div>
        <div class="breadcrumb-item">Riwayat</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Riwayat Event Lelang</h2>
    <p class="section-lead">
        Kelola Riwayat Event Lelang 
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Riwayat Event Lelang Offline') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lelang-event">
                            <thead>
                                <tr>
                                    <th>Kode Event</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Lokasi</th>
                                    <th>Penyelengaraan</th>
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
