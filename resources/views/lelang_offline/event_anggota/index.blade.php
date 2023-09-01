@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Anggota Event Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event') }}">Event</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event.show', $event->event_lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Anggota Event Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Anggota Event Lelang</h2>
    <p class="section-lead">
        Kelola Anggota Event Lelang
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Anggota Event Lelang Offline') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('offline.event.anggota.create', $event->event_lelang_id) }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lelang-event-anggota">
                            <thead>
                                <tr>
                                    <th>Kode Peserta</th>
                                    <th>Username</th>
                                    <th>Nama Anggota</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('offline.event.show', $event->event_lelang_id) }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
