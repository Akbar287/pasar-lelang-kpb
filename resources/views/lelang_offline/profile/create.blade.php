@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Buat Profile Offline</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.profile') }}">Profile</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Profil</h2>
    <p class="section-lead">
        Tambahkan data Profil anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('offline.profile.store') }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Profil') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="penyelenggara_pasar_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <select id="penyelenggara_pasar_lelang_id" type="text" @if(count($penyelenggara_pasar_lelang) == 0) disabled @endif class="custom-select @error('penyelenggara_pasar_lelang_id') is-invalid @enderror" name="penyelenggara_pasar_lelang_id">
                                                @foreach ($penyelenggara_pasar_lelang as $ppl)
                                                <option {{ old('penyelenggara_pasar_lelang_id') == $ppl->penyelenggara_pasar_lelang_id ? 'selected' : '' }} value="{{ $ppl->penyelenggara_pasar_lelang_id }}">{{ $ppl->admin()->first()->member()->first()->ktp()->first()->nama . ' ('. $ppl->admin()->first()->member()->first()->ktp()->first()->nik .')' }}</option>
                                                @endforeach
                                            </select>
                                        
                                        @error('penyelenggara_pasar_lelang_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="registrasi_id" class="col-md-4 col-form-label text-md-end">{{ __('Registrasi Id')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="registrasi_id" type="text"
                                                class="form-control @error('registrasi_id') is-invalid @enderror" name="registrasi_id"
                                                value="{{ old("registrasi_id") }}">
                                        
                                        @error('registrasi_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_profile" class="col-md-4 col-form-label text-md-end">{{ __('Nama Profile')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="nama_profile" type="text"
                                                class="form-control @error('nama_profile') is-invalid @enderror" name="nama_profile"
                                                value="{{ old("nama_profile") }}">
                                        
                                        @error('nama_profile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <textarea  id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" cols="30" rows="10">{{ old('keterangan') }}</textarea>
                                        
                                        @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="is_open" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <select id="is_open" type="text" class="custom-select @error('is_open') is-invalid @enderror" name="is_open">
                                                <option {{ old('is_open') == true ? 'selected' : '' }} value="{{ 'true' }}">Dibuka</option>
                                                <option {{ old('is_open') == false ? 'selected' : '' }} value="{{ 'false' }}">Ditutup</option>
                                            </select>
                                        
                                        @error('is_open')
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
                                        <a type="button" href="{{ route('offline.profile') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
