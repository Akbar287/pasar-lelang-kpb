@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jenis Harga</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis') }}">Jenis</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis.harga') }}">Harga</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis.harga.show', $jenisHarga->jenis_harga_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Jenis Harga</h2>
    <p class="section-lead">
        Ubah data Jenis Harga anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('konfigurasi.jenis.harga.update', $jenisHarga->jenis_harga_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Data Jenis Harga') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_jenis_harga" class="col-md-4 col-form-label text-md-end">{{ __('Nama Jenis Harga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nama_jenis_harga" type="text"
                                            class="form-control @error('nama_jenis_harga') is-invalid @enderror" name="nama_jenis_harga"
                                            value="{{ $jenisHarga->nama_jenis_harga }}" autocomplete="name"
                                            autofocus>
            
                                        @error('nama_jenis_harga')
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
                                        <a type="button" href="{{ route('konfigurasi.jenis.harga.show', $jenisHarga->jenis_harga_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


