@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Saldo</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Saldo</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Saldo</h2>
    <p class="section-lead">
        Lihat Saldo anda.
    </p>
    <div class="row">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Saldo') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4 class="title">Rp. {{ number_format($saldo, 0, ".", ",") }}</h4>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                            <a href="{{ route('home.saldo.deposit') }}" class="btn btn-primary btn-block">Deposit</a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                            <a href="{{ route('home.saldo.withdraw') }}" class="btn btn-info btn-block">Withdraw</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Riwayat Transaksi') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('home.saldo.riwayat') }}" class="btn btn-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 ">
                            <div class="table-responsive">
                                <table class="table-hover table-stripped table table-rekening-bank">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Rekening Bank</th>
                                            <th>Jenis Transaksi</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Auth::user()->informasi_akun()->first()->rekening_bank()->join('keuangan', 'keuangan.rekening_bank_id', 'rekening_bank.rekening_bank_id')->join('jenis_transaksi', 'jenis_transaksi.jenis_transaksi_id', 'keuangan.jenis_transaksi_id')->join('bank', 'bank.bank_id', 'rekening_bank.bank_id')->orderBy('rekening_bank.created_at', 'desc')->limit(10)->get() as $rb)
                                        <tr>
                                            <td>{{ $rb->created_at->format('d F Y') }}</td>
                                            <td>{{ $rb->nama_bank . ' ('. $rb->nomor_rekening .')' }}</td>
                                            <td>{{ $rb->nama_jenis }}</td>
                                            <td>{{ 'Rp. '. number_format($rb->jumlah, 0, ".", ",") }}</td>
                                            <td>{!! ($rb->keuangan()->where('keuangan_id', $rb->keuangan_id)->first()->verified_log()->count() == 0) ? '<div class="badge badge-info">Belum</div>' : ($rb->keuangan()->where('keuangan_id', $rb->keuangan_id)->first()->verified_log()->first()->is_agree ? '<div class="badge badge-success">Disetujui</div>' : '<div class="badge badge-danger">Tidak Disetujui</div>') !!}</td>
                                            <td><a href="{{ route('home.saldo.keuangan_detail', $rb->keuangan_id) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a></td>
                                        </tr>
                                        @endforeach
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
