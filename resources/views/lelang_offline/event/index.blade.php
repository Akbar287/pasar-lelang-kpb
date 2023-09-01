@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Event Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item">Event Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Event Lelang</h2>
    <p class="section-lead">
        Kelola Event Lelang 
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Event Lelang Offline') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('offline.event.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
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
