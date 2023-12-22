@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Perjanjian Jual Beli</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.laporan') }}">Laporan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.laporan.perjanjian_jual_beli') }}">Perjanjian Jual Beli</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.laporan.perjanjian_jual_beli.show', $perjanjianJualBeliPasal->perjanjian_jual_beli_pasal_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Perjanjian Jual Beli</h2>
    <p class="section-lead">
        Ubah data Perjanjian Jual Beli anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('konfigurasi.laporan.perjanjian_jual_beli.update', $perjanjianJualBeliPasal->perjanjian_jual_beli_pasal_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Data Perjanjian Jual Beli') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="key" class="col-md-4 col-form-label text-md-end">{{ __('Pasal') }}</label>

                                    <div class="col-md-6">
                                        <input id="key" type="text"
                                            class="form-control @error('key') is-invalid @enderror" name="key"
                                            value="{{ $perjanjianJualBeliPasal->key }}" />
            
                                        @error('key')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="value" class="col-md-4 col-form-label text-md-end">{{ __('Isi Pasal') }}</label>
            
                                    <div class="col-md-6">
                                        <textarea id="value" type="text" class="form-control @error('value') is-invalid @enderror" name="value" cols="30" rows="10">{{ $perjanjianJualBeliPasal->value }}</textarea>

                                        @error('value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                                        <a type="button" href="{{ route('konfigurasi.laporan.perjanjian_jual_beli.show', $perjanjianJualBeliPasal->perjanjian_jual_beli_pasal_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <button type="submit" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


