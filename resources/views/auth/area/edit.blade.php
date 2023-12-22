@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Area</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil') }}">Profil</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil.area') }}">Area</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil.area.show', $areaMember->area_member_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Area</h2>
    <p class="section-lead">
        Ubah data Area anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('home.profil.area.update', $areaMember->area_member_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Data Area') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="provinsi_id" class="col-md-4 col-form-label text-md-end">{{ __('Provinsi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('provinsi_id') is-invalid @enderror" name="provinsi_id" id="provinsi_id">
                                            <option value="0">Pilih Provinsi</option>
                                            @foreach($alamat['provinsi'] as $p)
                                            <option {{ $areaMember->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->provinsi_id == $p->provinsi_id ? 'selected' : '' }} value="{{ $p->provinsi_id }}">{{ $p->nama_provinsi }}</option>
                                            @endforeach
                                        </select>
            
                                        @error('provinsi_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="kabupaten_id" class="col-md-4 col-form-label text-md-end">{{ __('Kabupaten')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('kabupaten_id') is-invalid @enderror" name="kabupaten_id" id="kabupaten_id">
                                            <option value="0">Pilih Kabupaten</option>
                                            @foreach($alamat['kabupaten'] as $p)
                                            <option {{ $areaMember->desa()->first()->kecamatan()->first()->kabupaten()->first()->kabupaten_id == $p->kabupaten_id ? 'selected' : '' }} value="{{ $p->kabupaten_id }}">{{ $p->nama_kabupaten }}</option>
                                            @endforeach
                                        </select>
            
                                        @error('kabupaten_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="kecamatan_id" class="col-md-4 col-form-label text-md-end">{{ __('Kecamatan')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('kecamatan_id') is-invalid @enderror" name="kecamatan_id" id="kecamatan_id">
                                            <option value="0">Pilih Kecamatan</option>
                                            @foreach($alamat['kecamatan'] as $p)
                                            <option {{ $areaMember->desa()->first()->kecamatan()->first()->kecamatan_id == $p->kecamatan_id ? 'selected' : '' }} value="{{ $p->kecamatan_id }}">{{ $p->nama_kecamatan }}</option>
                                            @endforeach
                                        </select>
            
                                        @error('kecamatan_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="desa_id" class="col-md-4 col-form-label text-md-end">{{ __('Desa')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('desa_id') is-invalid @enderror" name="desa_id" id="desa_id">
                                            <option value="0">Pilih Desa</option>
                                            @foreach($alamat['desa'] as $p)
                                            <option {{ $areaMember->desa()->first()->desa_id == $p->desa_id ? 'selected' : '' }} value="{{ $p->desa_id }}">{{ $p->nama_desa }}</option>
                                            @endforeach
                                        </select>
            
                                        @error('desa_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat') }}</label>
            
                                    <div class="col-md-6">
                                        <input id="alamat" type="text"
                                            class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                            value="{{ $areaMember->alamat }}" />
            
                                        @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kode_pos" class="col-md-4 col-form-label text-md-end">{{ __('Kode Pos') }}</label>
            
                                    <div class="col-md-6">
                                        <input id="kode_pos" type="text"
                                            class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos"
                                            value="{{ $areaMember->kode_pos }}" />
            
                                        @error('kode_pos')
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
                                        <a type="button" href="{{ route('home.profil.area.show', $areaMember->area_member_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


