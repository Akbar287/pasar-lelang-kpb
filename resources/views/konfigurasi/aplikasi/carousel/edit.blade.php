@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Carousel</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.aplikasi') }}">Aplikasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.aplikasi.carousel') }}">Carousel</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.aplikasi.carousel.show', $carousel->carousel_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Carousel</h2>
    <p class="section-lead">
        Ubahkan data Carousel.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('konfigurasi.aplikasi.carousel.update', $carousel->carousel_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Carousel') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="aplikasi_id" class="col-md-4 col-form-label text-md-end">{{ __('Aplikasi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <select name="aplikasi_id" id="aplikasi_id" class="form-control @error('aplikasi_id') is-invalid @enderror">
                                                @foreach($aplikasi as $apl)
                                                <option {{ $carousel->aplikasi_id == $apl->aplikasi_id ? 'selected' : '' }} value="{{ $apl->aplikasi_id }}">{{ $apl->nama_aplikasi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('aplikasi_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Judul')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="title" type="text"
                                                class="form-control @error('title') is-invalid @enderror" name="title"
                                                value="{{ $carousel->title }}" />
                                        </div>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="subtitle" class="col-md-4 col-form-label text-md-end">{{ __('Sub-Judul')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <textarea id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" cols="30" rows="10">{{ $carousel->subtitle }}</textarea>
                                        </div>
                                        @error('subtitle')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="urutan" class="col-md-4 col-form-label text-md-end">{{ __('Urutan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="urutan" class="form-control @error('urutan') is-invalid @enderror" name="urutan" value="{{ $carousel->urutan }}" type="number" />
                                        </div>
                                        @error('urutan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="page" class="col-md-4 col-form-label text-md-end">{{ __('Halaman')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="page" class="form-control @error('page') is-invalid @enderror" name="page" value="{{ $carousel->page }}" type="text" />
                                        </div>
                                        @error('page')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="gambar" class="col-md-4 col-form-label text-md-end">{{
                                        __('Gambar Carousel')
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

                                        <img src="{{ asset('storage/carousel/' . $carousel->image_src) }}" alt="{{ $carousel->image_src }}" class="img img-thumbnail img-temporary" style="width: 800px; height: auto">
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
                                        <a type="button" href="{{ route('konfigurasi.aplikasi.carousel.show', $carousel->carousel_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
