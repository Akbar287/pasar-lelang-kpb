@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Jaminan Resi Gudang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Resi Gudang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Penerimaan Jaminan Resi Gudang</h2>
    <p class="section-lead">
        Kelola Jaminan Resi Gudang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Penerimaan Jaminan Resi Gudang') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('administrasi.jaminan.penerimaan.resi_gudang.create', $detailJaminan->detail_jaminan_id) }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-jaminan-resi_gudang">
                            <thead>
                                <tr>
                                    <th>Nama Resi Gudang</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Nilai Resi Gudang / Jaminan</th>
                                    <th>Haircut</th>
                                    <th>Nilai Penyesuaian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
