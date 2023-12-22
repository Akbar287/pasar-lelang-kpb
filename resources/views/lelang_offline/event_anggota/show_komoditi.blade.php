@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Anggota Event Komoditi</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event') }}">Event</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event.show', $event->event_lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Detail Anggota Komoditi</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Anggota Event</h2>
    <p class="section-lead">
        detail data Detail Anggota Event anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Penjual komoditi') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Penjual</th>
                                        <th>Komoditi</th>
                                    </thead>
                                    <tbody>
                                        @foreach($penjual as $p)
                                        <tr>
                                            <td rowspan="{{ count($p['komoditas']) }}">{{ $loop->iteration }}</td>
                                            <td rowspan="{{ count($p['komoditas']) }}">{{ $p['nama'] }}</td>
                                            @if(count($p['komoditas']) > 0) <td>{{ $p['komoditas']['0'] }}</td> @endif
                                        </tr>
                                        @if(count($p['komoditas']) > 1)
                                        @for($i = 1; $i < count($p['komoditas']); $i++)
                                        <tr>
                                            <td>{{ $p['komoditas'][$i] }}</td>
                                        </tr>
                                        @endfor
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Pembeli') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Pembeli</th>
                                        <th>Kode Peserta Sesi</th>
                                    </thead>
                                    <tbody>
                                        @foreach($event->daftar_peserta_lelang()->get() as $dpl)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dpl->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}</td>
                                            <td>{{ $dpl->kode_peserta_lelang }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Pilihan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                    <a type="button" href="{{ route('offline.event.show', $event->event_lelang_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('offline.event.anggota.show_komoditi_cetak', $event->event_lelang_id) }}" class="btn btn-success mr-2"><i class="fas fa-print"></i> Cetak</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
