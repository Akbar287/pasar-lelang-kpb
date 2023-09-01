@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Komoditas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lain</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain.komoditas') }}">Komoditas</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Komoditas</h2>
    <p class="section-lead">
        Tambahkan data Komoditas anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('master.lain.komoditas.store') }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Komoditas') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_komoditas_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Komoditas')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('jenis_komoditas_id') is-invalid @enderror" name="jenis_komoditas_id" id="jenis_komoditas_id">
                                            @foreach($jenisKomoditas as $jk)
                                            <option {{ old('jenis_komoditas_id') == $jk->jenis_komoditas_id ? 'selected' : '' }} value="{{ $jk->jenis_komoditas_id }}">{{ $jk->nama_jenis_komoditas }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('jenis_komoditas_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_komoditas" class="col-md-4 col-form-label text-md-end">{{ __('Nama Komoditas')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nama_komoditas" type="text"
                                            class="form-control @error('nama_komoditas') is-invalid @enderror" name="nama_komoditas"
                                            value="{{ old("nama_komoditas") }}" autocomplete="name"
                                            autofocus>
            
                                        @error('nama_komoditas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="satuan_ukuran" class="col-md-4 col-form-label text-md-end">{{ __('Satuan Ukur')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="satuan_ukuran" type="text"
                                            class="form-control @error('satuan_ukuran') is-invalid @enderror" name="satuan_ukuran"
                                            value="{{ old("satuan_ukuran") }}" autocomplete="name"
                                            autofocus>
            
                                        @error('satuan_ukuran')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="inisiasi" class="col-md-4 col-form-label text-md-end">{{ __('Inisiasi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('inisiasi') is-invalid @enderror" name="inisiasi" id="inisiasi">
                                            <option {{ old('inisiasi') == 'true' ? 'selected' : '' }} value="true">{{ "Ya" }}</option>
                                            <option {{ old('inisiasi') == 'false' ? 'selected' : '' }} value="false">{{ "Tidak" }}</option>
                                        </select>
            
                                        @error('inisiasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kadaluarsa" class="col-md-4 col-form-label text-md-end">{{ __('Kadaluarsa')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('kadaluarsa') is-invalid @enderror" name="kadaluarsa" id="kadaluarsa">
                                            <option {{ old('kadaluarsa') == 'Ya' ? 'selected' : '' }} value="{{ 'true' }}">{{ "Ya" }}</option>
                                            <option {{ old('kadaluarsa') == 'Tidak' ? 'selected' : '' }} value="{{ 'false' }}">{{ "Tidak" }}</option>
                                        </select>
            
                                        @error('kadaluarsa')
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
                                        <a type="button" href="{{ route('master.lain.komoditas') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
