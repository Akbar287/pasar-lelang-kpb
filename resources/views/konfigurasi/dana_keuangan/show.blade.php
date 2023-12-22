@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Dana keuangan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.dana_keuangan') }}">Dana keuangan</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Dana keuangan</h2>
    <p class="section-lead">
        Detail data Dana keuangan anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Dana keuangan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis" class="col-md-4 col-form-label text-md-end">{{ __('Jenis')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jenis" readonly type="text"
                                        class="form-control" name="jenis"
                                        value="{{ $danaKeuangan->jenis }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jumlah_dana" class="col-md-4 col-form-label text-md-end">{{ __('Saldo')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jumlah_dana" readonly type="text"
                                        class="form-control" name="jumlah_dana"
                                        value="{{ $danaKeuangan->jumlah_dana ? 'Aktif' : "Tidak" }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="keterangan" readonly class="form-control" name="keterangan" cols="30" rows="10">{{ $danaKeuangan->keterangan }}</textarea>
                                </div>
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
                                        <a type="button" href="{{ route('konfigurasi.dana_keuangan') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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

