@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Operator Pasar Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.operator') }}">Profile</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Operator Pasar Lelang</h2>
    <p class="section-lead">
        detail data Operator Pasar Lelang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Operator Pasar Lelang') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="offline_profile_id" class="col-md-4 col-form-label text-md-end">{{ __('Offline Profile')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="offline_profile_id" type="text"
                                                class="form-control" name="user_id" readonly
                                                value="{{ $operator->offline_profile()->first()->nama_profile }}">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="user_id" class="col-md-4 col-form-label text-md-end">{{ __('User Id')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="user_id" type="text"
                                                class="form-control" name="user_id" readonly
                                                value="{{ $operator->user_id }}">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_lengkap" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="nama_lengkap" type="text" readonly
                                                class="form-control" name="nama_lengkap"
                                                value="{{ $operator->nama_lengkap }}">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="is_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="nama_lengkap" type="text" readonly
                                                class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap"
                                                value="{{ $operator->is_aktif == true ? 'Aktif' : 'Tidak Aktif' }}">
                                        
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
                                        <a type="button" href="{{ route('offline.operator.edit', $operator->operator_pasar_lelang_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('offline.operator.destroy', $operator->operator_pasar_lelang_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Data Operator akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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
