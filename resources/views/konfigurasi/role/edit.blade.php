@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Role</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.role') }}">Role</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.role.show', $role->role_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Role</h2>
    <p class="section-lead">
        Ubah data Role anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('konfigurasi.role.update', $role->role_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Data Role') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_role" class="col-md-4 col-form-label text-md-end">{{ __('Nama Role')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nama_role" type="text"
                                            class="form-control @error('nama_role') is-invalid @enderror" name="nama_role"
                                            value="{{ $role->nama_role }}" autocomplete="name"
                                            autofocus>
            
                                        @error('nama_role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="is_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Status Aktif')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('is_aktif') is-invalid @enderror" name="is_aktif" id="is_aktif">
                                            <option {{ $role->is_aktif == true ? 'selected' : '' }} value="{{ 'true' }}">{{ "Aktif" }}</option>
                                            <option {{ $role->is_aktif == false ? 'selected' : '' }} value="{{ 'false' }}">{{ "Tidak" }}</option>
                                        </select>
            
                                        @error('is_aktif')
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
                                        <textarea id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" cols="30" rows="10">{{ $role->keterangan }}</textarea>
        
                                    @error('keterangan')
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
                                        <a type="button" href="{{ route('konfigurasi.role.show', $role->role_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


