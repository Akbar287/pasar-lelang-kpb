@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Offline profile</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.profile') }}">Profile</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Offline profile</h2>
    <p class="section-lead">
        detail data Offline profile anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Offline profile') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="registrasi_id" class="col-md-4 col-form-label text-md-end">{{ __('Registrasi Id')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="registrasi_id" type="text" readonly
                                                class="form-control @error('registrasi_id') is-invalid @enderror" name="registrasi_id"
                                                value="{{ $profile->registrasi_id }}">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_profile" class="col-md-4 col-form-label text-md-end">{{ __('Nama Profile')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="nama_profile" type="text" readonly 
                                                class="form-control @error('nama_profile') is-invalid @enderror" name="nama_profile"
                                                value="{{ $profile->nama_profile }}">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_register" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Register')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="tanggal_register" type="date" readonly
                                                class="form-control @error('tanggal_register') is-invalid @enderror" name="tanggal_register"
                                                value="{{ $profile->tanggal_register }}">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <textarea readonly id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" cols="30" rows="10">{{ $profile->keterangan }}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="is_open" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="is_open" type="text" readonly
                                                class="form-control" name="tanggal_register"
                                                value="{{ $profile->is_open ? 'dibuka' : 'ditutup' }}">
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
                                        <a type="button" href="{{ route('offline.profile.edit', $profile->offline_profile_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('offline.profile.destroy', $profile->offline_profile_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Data Profile akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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
