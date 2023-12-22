@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Aplikasi</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.aplikasi') }}">Aplikasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.aplikasi.aplikasi') }}">Aplikasi</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Aplikasi</h2>
    <p class="section-lead">
        Tambahkan data Aplikasi.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('konfigurasi.aplikasi.aplikasi.store') }}" method="post" enctype="multipart/form-data">@csrf
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Aplikasi') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="nama_aplikasi" class="col-md-4 col-form-label text-md-end">{{ __('Nama Aplikasi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="nama_aplikasi" type="text"
                                                class="form-control @error('nama_aplikasi') is-invalid @enderror" name="nama_aplikasi"
                                                value="{{ old("nama_aplikasi") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('nama_aplikasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="header_description" class="col-md-4 col-form-label text-md-end">{{ __('Deksripsi Header')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <textarea id="header_description" class="form-control @error('header_description') is-invalid @enderror" name="header_description" cols="30" rows="10">{{ old('header_description') }}</textarea>
                                        </div>
                                        @error('header_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="footer_description" class="col-md-4 col-form-label text-md-end">{{ __('Deskripsi Footer')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <textarea id="footer_description" class="form-control @error('footer_description') is-invalid @enderror" name="footer_description" cols="30" rows="10">{{ old('footer_description') }}</textarea>
                                        </div>
                                        @error('footer_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="gambar" class="col-md-4 col-form-label text-md-end">{{
                                        __('Latar Belakang Header')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input type="file" name="gambar" class="custom-file-input" id="gambar">
                                            <label class="custom-file-label" for="gambar">Pilih File</label>
                                        </div>

                                        @error('gambar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <img src="" alt="{{ old("gambar") }}" class="img img-thumbnail img-temporary d-none" style="width: 800px; height: auto">
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
                                        <a type="button" href="{{ route('konfigurasi.aplikasi.aplikasi') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
