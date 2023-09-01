@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Gudang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga') }}">Lembaga</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga.gudang') }}">Gudang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga.gudang.show', $gudang->gudang_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Gudang</h2>
    <p class="section-lead">
        Ubah data Gudang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('master.lembaga.gudang.update', $gudang->gudang_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Gudang') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="penyelenggara_pasar_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara Pasar Lelang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('penyelenggara_pasar_lelang_id') is-invalid @enderror" name="penyelenggara_pasar_lelang_id" id="penyelenggara_pasar_lelang_id">
                                            <option value="0" selected>Pilih Penyelenggara</option>
                                            @foreach($penyelenggaraPasarLelang as $ppl)
                                            <option {{ $gudang->penyelenggara_pasar_lelang()->first()->penyelenggara_pasar_lelang_id == $ppl->penyelenggara_pasar_lelang_id ? 'selected' : '' }} value="{{ $ppl->penyelenggara_pasar_lelang_id }}">{{ $ppl->admin()->first()->member()->first()->ktp()->first()->nama }}</option>
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
                                    <label for="gudang_kode" class="col-md-4 col-form-label text-md-end">{{ __('Kode Gudang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="gudang_kode" type="text" readonly
                                            class="form-control @error('gudang_kode') is-invalid @enderror"
                                            value="{{ $gudang->gudang_kode }}" autocomplete="name" name="gudang_kode"
                                            autofocus>
            
                                        @error('gudang_kode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_gudang" class="col-md-4 col-form-label text-md-end">{{ __('Nama Gudang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nama_gudang" type="text"
                                            class="form-control @error('nama_gudang') is-invalid @enderror" name="nama_gudang"
                                            value="{{ $gudang->nama_gudang }}" autocomplete="name"
                                            autofocus>
            
                                        @error('nama_gudang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="contact_person" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pemilik')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="contact_person" type="text"
                                            class="form-control @error('contact_person') is-invalid @enderror" name="contact_person"
                                            value="{{ $gudang->contact_person }}" autocomplete="name"
                                            autofocus>
            
                                        @error('contact_person')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="contact_number" class="col-md-4 col-form-label text-md-end">{{ __('Nomor HP yang bisa dihubungi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="contact_number" type="text"
                                            class="form-control @error('contact_number') is-invalid @enderror" name="contact_number"
                                            value="{{ $gudang->contact_number }}" autocomplete="name"
                                            autofocus>
            
                                        @error('contact_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_pengelola" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pengelola')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nama_pengelola" type="text"
                                            class="form-control @error('nama_pengelola') is-invalid @enderror" name="nama_pengelola"
                                            value="{{ $gudang->nama_pengelola }}" autocomplete="name"
                                            autofocus>
            
                                        @error('nama_pengelola')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" cols="30" rows="10">{{ $gudang->alamat }}</textarea>
            
                                        @error('alamat')
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
                                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" cols="30" rows="10">{{ $gudang->keterangan }}</textarea>
            
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
                                        <a type="button" href="{{ route('master.lembaga.gudang.show', $gudang->gudang_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


