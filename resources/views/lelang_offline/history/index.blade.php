@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Riwayat Lelang Offline</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Riwayat Lelang Offline</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Riwayat Lelang Offline</h2>
    <p class="section-lead">
        Lihat Riwayat Lelang Offline
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Lihat Lelang Offline') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('offline.history') }}" method="get">@csrf
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-5">
                                <input type="date" name="waktu_mulai" class="form-control" value="{{ $waktuMulai }}" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-5">
                                <input type="date" name="waktu_selesai" class="form-control" value="{{ $waktuSelesai }}" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-2">
                                <button type="submit" class="btn btn-success btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-sesi-lelang">
                                    <thead>
                                        <tr>
                                            <th>Penyelenggara</th>
                                            <th>Kode Event</th>
                                            <th>Nama Event</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Jenis</th>
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
    </div>
</div>
@endsection
