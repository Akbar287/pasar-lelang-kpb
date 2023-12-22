@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Buat Event</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event') }}">Event</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Event</h2>
    <p class="section-lead">
        Tambahkan data Event anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('offline.event.store') }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Event Lelang') }}</h4>
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
                                    <label for="event_kode" class="col-md-4 col-form-label text-md-end">{{ __('Kode Event')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="event_kode" type="text"
                                                class="form-control @error('event_kode') is-invalid @enderror" name="event_kode"
                                                value="{{ old("event_kode") }}">
                                        
                                        @error('event_kode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Nama Lelang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="nama_lelang" type="text"
                                                class="form-control @error('nama_lelang') is-invalid @enderror" name="nama_lelang"
                                                value="{{ old("nama_lelang") }}">
                                        
                                        @error('nama_lelang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Lelang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="tanggal_lelang" type="date"
                                                class="form-control @error('tanggal_lelang') is-invalid @enderror" name="tanggal_lelang"
                                                value="{{ is_null(old("tanggal_lelang")) ? date('Y-m-d') : old("tanggal_lelang") }}">
                                        
                                        @error('tanggal_lelang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jam_mulai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Mulai')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="jam_mulai" type="time"
                                                class="form-control @error('jam_mulai') is-invalid @enderror" name="jam_mulai"
                                                value="{{ old("jam_mulai") }}">
                                        
                                        @error('jam_mulai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jam_selesai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Selesai')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="jam_selesai" type="time"
                                                class="form-control @error('jam_selesai') is-invalid @enderror" name="jam_selesai"
                                                value="{{ old("jam_selesai") }}">
                                        
                                        @error('jam_selesai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="lokasi" class="col-md-4 col-form-label text-md-end">{{ __('Lokasi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <textarea id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" cols="30" rows="10">{{ old("lokasi") }}</textarea>
                                        
                                        @error('lokasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="ketua_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Ketua Lelang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="ketua_lelang" type="text"
                                                class="form-control @error('ketua_lelang') is-invalid @enderror" name="ketua_lelang"
                                                value="{{ old("ketua_lelang") }}">

                                        @error('ketua_lelang')
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
                                            <textarea id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" cols="30" rows="10">{{ old("keterangan") }}</textarea>
                                        
                                        @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="is_open" class="col-md-4 col-form-label text-md-end">{{ __('Terbuka Untuk Penjual')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <select id="is_open" type="text" class="custom-select @error('is_open') is-invalid @enderror" name="is_open">
                                                <option {{ old('is_open') == true ? 'selected' : '' }} value="{{ 'true' }}">Open</option>
                                                <option {{ old('is_open') == false ? 'selected' : '' }} value="{{ 'false' }}">Closed</option>
                                            </select>
                                        
                                        @error('is_open')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="is_online" class="col-md-4 col-form-label text-md-end">{{ __('hybrid')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <select id="is_online" type="text" class="custom-select @error('is_online') is-invalid @enderror" name="is_online">
                                                <option {{ old('is_online') == true ? 'selected' : '' }} value="{{ 'true' }}">Online - Offline</option>
                                                <option {{ old('is_online') == false ? 'selected' : '' }} value="{{ 'false' }}">Offline</option>
                                            </select>
                                        
                                        @error('is_online')
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
                                        <a type="button" href="{{ route('offline.event') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
