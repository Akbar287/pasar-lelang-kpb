@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Riwayat Event Lelang Online</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online') }}">Lelang Online</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event') }}">Event Lelang Online</a></div>
        <div class="breadcrumb-item">Riwayat</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Riwayat Event Lelang Online</h2>
    <p class="section-lead">
        Kelola Riwayat Event Lelang Online.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Riwayat Event Lelang Online') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('online.event.history') }}" method="get"> @csrf
                        <div class="row mb-4">
                            <div class="col-4">
                                <input type="date" name="tanggal" value="{{ $form['date'] }}" class="form-control" id="tanggal" />
                            </div>
                            <div class="col-4">
                                <select name="sesi" id="sesi" class="custom-select">
                                    <option value="semua" {{ $form['sesi'] == 'semua' ? 'selected' : '' }}>Semua Sesi</option>
                                    @foreach($sesi as $s)
                                    <option {{ $form['sesi'] == $s->master_sesi_lelang_id ? 'selected' : '' }} value="{{ $s->master_sesi_lelang_id }}">{{ $s->sesi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-success btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover table-lelang-event">
                            <thead>
                                <tr>
                                    <th>Penyelenggara</th>
                                    <th>Tanggal</th>
                                    <th>Sesi</th>
                                    <th>Produk Lelang</th>
                                    <th>Harga Awal</th>
                                    <th>Kelipatan Harga</th>
                                    <th>Peserta</th>
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
