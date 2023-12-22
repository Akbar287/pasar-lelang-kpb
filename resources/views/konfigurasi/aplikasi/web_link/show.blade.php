@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Web Link</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.aplikasi') }}">Aplikasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.aplikasi.web_link') }}">Web Link</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Web Link</h2>
    <p class="section-lead">
        Detailkan data Web Link.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Web Link') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="aplikasi_id" class="col-md-4 col-form-label text-md-end">{{ __('Aplikasi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="aplikasi_id" type="text" readonly
                                                class="form-control @error('aplikasi_id') is-invalid @enderror" name="aplikasi_id"
                                                value="{{ $webLink->aplikasi()->first()->nama_aplikasi }}" />
                                        </div>
                                        @error('aplikasi_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="nama_web" class="col-md-4 col-form-label text-md-end">{{ __('Nama Web')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="nama_web" type="text" readonly
                                                class="form-control @error('nama_web') is-invalid @enderror" name="nama_web"
                                                value="{{ $webLink->nama_web }}" />
                                        </div>
                                        @error('nama_web')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="link" class="col-md-4 col-form-label text-md-end">{{ __('Link')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <textarea id="link" readonly class="form-control @error('link') is-invalid @enderror" name="link" cols="30" rows="10">{{ $webLink->link }}</textarea>
                                        </div>
                                        @error('link')
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
                                        <a type="button" href="{{ route('konfigurasi.aplikasi.web_link') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('konfigurasi.aplikasi.web_link.edit', $webLink->web_links_id) }}" class="btn btn-success mr-2"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('konfigurasi.aplikasi.web_link.destroy', $webLink->web_links_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Web Link dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger ml-2"><i class="fas fa-trash"></i> Hapus</button>
                                        </form>
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
