@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Buat Operator Offline</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.operator') }}">Operator</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Operator</h2>
    <p class="section-lead">
        Tambahkan data Operator anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('offline.operator.store') }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Profil') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="offline_profile_id" class="col-md-4 col-form-label text-md-end">{{ __('Offline Profile')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <select id="offline_profile_id" {{ $offlineProfile->count() > 0 ? '' : 'disabled' }} class="custom-select @error('offline_profile_id') is-invalid @enderror" name="offline_profile_id">
                                                @foreach($offlineProfile as $op)
                                                <option {{ old('offline_profile_id') == $op->offline_profile_id ? 'selected' : '' }} value="{{ $op->offline_profile_id }}">{{ $op->nama_profile }}</option>
                                                @endforeach
                                            </select>
                                        
                                        @error('offline_profile_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="user_id" class="col-md-4 col-form-label text-md-end">{{ __('User Id')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="user_id" type="text"
                                                class="form-control @error('user_id') is-invalid @enderror" name="user_id"
                                                value="{{ old("user_id") }}">
                                        
                                        @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                value="{{ old("password") }}">
                                            <div class="input-group-append" id="button-check">
                                                <span class="input-group-text"><span class="fas fa-eye"></span></span>
                                            </div>
                                        </div>
                                        
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_lengkap" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="nama_lengkap" type="text"
                                                class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap"
                                                value="{{ old("nama_lengkap") }}">
                                        
                                        @error('nama_lengkap')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="is_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <select id="is_aktif" type="text" class="custom-select @error('is_aktif') is-invalid @enderror" name="is_aktif">
                                                <option {{ old('is_aktif') == true ? 'selected' : '' }} value="{{ 'true' }}">Aktif</option>
                                                <option {{ old('is_aktif') == false ? 'selected' : '' }} value="{{ 'false' }}">Tidak Aktif</option>
                                            </select>
                                        
                                        @error('is_aktif')
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
                                        <a type="button" href="{{ route('offline.operator') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
