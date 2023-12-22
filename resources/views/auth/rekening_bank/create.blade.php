@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Rekening Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil') }}">Profil</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil.rekening_bank') }}">Rekening Bank</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Rekening Bank</h2>
    <p class="section-lead">
        Tambahkan data Rekening Bank anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('home.profil.rekening_bank.store') }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Rekening Bank') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="bank_id" class="col-md-4 col-form-label text-md-end">{{ __('Nama Bank')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('bank_id') is-invalid @enderror" name="bank_id" id="bank_id">
                                            @foreach($bank as $p)
                                            <option {{ old('bank_id') == $p->bank_id ? 'selected' : '' }} value="{{ $p->bank_id }}">{{ $p->nama_bank }}</option>
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
                                    <label for="nomor_rekening" class="col-md-4 col-form-label text-md-end">{{ __('No. Rekening') }}</label>
            
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
                                    <label for="nama_pemilik" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pemilik') }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nama_pemilik" type="text"
                                            class="form-control @error('nama_pemilik') is-invalid @enderror" name="nama_pemilik"
                                            value="{{ old("nama_pemilik") }}" />
            
                                        @error('nama_pemilik')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="cabang" class="col-md-4 col-form-label text-md-end">{{ __('Cabang') }}</label>
            
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
                                    <label for="mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Mata Uang') }}</label>
            
                                    <div class="col-md-6">
                                        <select id="mata_uang" type="text" class="custom-select @error('mata_uang') is-invalid @enderror" name="mata_uang">
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
                                        <a type="button" href="{{ route('home.profil.rekening_bank') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
