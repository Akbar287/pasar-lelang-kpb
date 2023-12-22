@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Rekening Pusat</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.rekening_pusat') }}">Rekening Pusat</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Rekening Pusat</h2>
    <p class="section-lead">
        Tambahkan data Rekening Pusat anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('konfigurasi.rekening_pusat.store') }}" method="post" enctype="multipart/form-data">@csrf
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Rekening Pusat') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="bank_id" class="col-md-4 col-form-label text-md-end">{{ __('Bank')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('bank_id') is-invalid @enderror" name="bank_id" id="bank_id">
                                            <option value="0">Pilih Bank</option>
                                            @foreach($bank as $ba)
                                            <option {{ old('bank_id') == $ba->bank_id ? 'selected' : '' }} value="{{ $ba->bank_id }}">{{ $ba->nama_bank }}</option>
                                            @endforeach
                                        </select>

                                        @error('bank_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_rekening" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nomor_rekening" type="text"
                                            class="form-control @error('nomor_rekening') is-invalid @enderror" name="nomor_rekening"
                                            value="{{ old("nomor_rekening") }}" />

                                        @error('nomor_rekening')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="cabang" class="col-md-4 col-form-label text-md-end">{{ __('Cabang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="cabang" type="text"
                                            class="form-control @error('cabang') is-invalid @enderror" name="cabang"
                                            value="{{ old("cabang") }}" />

                                        @error('cabang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="saldo" class="col-md-4 col-form-label text-md-end">{{ __('Saldo')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="saldo" type="text"
                                            class="form-control thousand-style @error('saldo') is-invalid @enderror" name="saldo"
                                            value="{{ old("saldo") }}" />

                                        @error('saldo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Mata Uang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('mata_uang') is-invalid @enderror" name="mata_uang" id="mata_uang">
                                            <option {{ old('mata_uang') == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                            <option {{ old('mata_uang') == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                        </select>

                                        @error('mata_uang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="aktif" class="col-md-4 col-form-label text-md-end">{{ __('Jadikan Utama')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('aktif') is-invalid @enderror" name="aktif" id="aktif">
                                            <option {{ old('aktif') == true ? 'selected' : '' }} value="{{ 'true' }}">{{ "Utama" }}</option>
                                            <option {{ old('aktif') == false ? 'selected' : '' }} value="{{ 'false' }}">{{ "Tidak" }}</option>
                                        </select>

                                        @error('aktif')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('status') is-invalid @enderror" name="status" id="status">
                                            <option {{ old('status') == true ? 'selected' : '' }} value="{{ 'true' }}">{{ "Aktif" }}</option>
                                            <option {{ old('status') == false ? 'selected' : '' }} value="{{ 'false' }}">{{ "Tidak" }}</option>
                                        </select>

                                        @error('status')
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
                                        <a type="button" href="{{ route('konfigurasi.rekening_pusat') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
