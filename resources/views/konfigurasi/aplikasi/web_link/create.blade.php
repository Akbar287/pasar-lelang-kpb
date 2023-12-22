@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Web Link</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.aplikasi') }}">Aplikasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.aplikasi.web_link') }}">Web Link</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Web Link</h2>
    <p class="section-lead">
        Tambahkan data Web Link.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('konfigurasi.aplikasi.web_link.store') }}" method="post" enctype="multipart/form-data">@csrf
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
                                            <select name="aplikasi_id" id="aplikasi_id" class="form-control @error('aplikasi_id') is-invalid @enderror">
                                                @foreach($aplikasi as $apl)
                                                <option {{ old('aplikasi_id') == $apl->aplikasi_id ? 'selected' : '' }} value="{{ $apl->aplikasi_id }}">{{ $apl->nama_aplikasi }}</option>
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
                                    <label for="nama_web" class="col-md-4 col-form-label text-md-end">{{ __('Nama Web')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="nama_web" type="text"
                                                class="form-control @error('nama_web') is-invalid @enderror" name="nama_web"
                                                value="{{ old("nama_web") }}" />
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
                                            <textarea id="link" class="form-control @error('link') is-invalid @enderror" name="link" cols="30" rows="10">{{ old('link') }}</textarea>
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
