@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Gudang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga.gudang') }}">Gudang</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Gudang</h2>
    <p class="section-lead">
        Detail data gudang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
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
                                    <input id="gudang_kode" type="text" readonly
                                        class="form-control" name="gudang_kode"
                                        value="{{ $gudang->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="gudang_kode" class="col-md-4 col-form-label text-md-end">{{ __('Kode Gudang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="gudang_kode" type="text" readonly
                                        class="form-control" name="gudang_kode"
                                        value="{{ $gudang->gudang_kode }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_gudang" class="col-md-4 col-form-label text-md-end">{{ __('Nama Gudang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nama_gudang" type="text"
                                        class="form-control" name="nama_gudang" readonly
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
                                    <input id="contact_person" type="text" readonly
                                        class="form-control" name="contact_person"
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
                                    <input id="contact_number" type="text" readonly
                                        class="form-control" name="contact_number"
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
                                        class="form-control" name="nama_pengelola" readonly
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
                                    <textarea class="form-control" name="alamat" id="alamat" readonly cols="30" rows="10">{{ $gudang->alamat }}</textarea>
        
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
                                    <textarea class="form-control" name="keterangan" readonly id="keterangan" cols="30" rows="10">{{ $gudang->keterangan }}</textarea>
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
                                    <a type="button" href="{{ route('master.lembaga.gudang') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('master.lembaga.gudang.edit', $gudang->gudang_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <form action="{{ route('master.lembaga.gudang.destroy', $gudang->gudang_id) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('Gudang akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

