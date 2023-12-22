@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Riwayat Transaksi Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('lelang') }}">Lelang</a></div>
        <div class="breadcrumb-item">Riwayat Transaksi Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Transaksi Lelang</h2>
    <p class="section-lead">
        Kelola Transaksi Lelang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Filter Transaksi Lelang Saya') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('lelang.transaksi') }}" method="get">@csrf
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 mb-4">
                                <input type="date" name="waktu_mulai" class="form-control" value="{{ $waktuMulai }}" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-4">
                                <input type="date" name="waktu_selesai" class="form-control" value="{{ $waktuSelesai }}" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 mb-3">
                                <select name="status" id="status" class="custom-select">
                                    <option {{ request('status') == 'all' ? 'selected': '' }} value="all">Semua Status</option>
                                    @foreach($statusAll as $s)
                                    <option {{ request('status') == $s->nama_status ? 'selected': '' }} value="{{ $s->nama_status }}">{{ $s->nama_status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 mb-3">
                                <select name="jenis" id="jenis" class="custom-select">
                                    <option {{ request('jenis') == 'penjual' ? 'selected': '' }} value="penjual">Penjual</option>
                                    <option {{ request('jenis') == 'pembeli' ? 'selected': '' }} value="pembeli">Pembeli</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 mb-3">
                                <select name="platform" id="platform" class="custom-select">
                                    <option {{ request('platform') == 'online' ? 'selected': '' }} value="online">Online</option>
                                    <option {{ request('platform') == 'offline' ? 'selected': '' }} value="offline">Offline</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-success btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-lelang-user">
                                    <thead>
                                        <tr>
                                            <th>Nomor Lelang</th>
                                            <th>Judul</th>
                                            <th>Kuantitas</th>
                                            <th>Harga Awal</th>
                                            <th>Harga Pemenang</th>
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
    </div>
</div>
@endsection
