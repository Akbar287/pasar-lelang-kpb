@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Alamat</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list') }}">List</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list.show', $anggota->informasi_akun_id) }}">Detail Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list.area.index', $anggota->informasi_akun_id) }}">Alamat</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list.area.show', [$anggota->informasi_akun_id, $area->area_member_id]) }}">Detail Alamat</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Alamat</h2>
    <p class="section-lead">
        Tambahkan data Alamat anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('master.anggota.list.area.update',[$anggota->informasi_akun_id, $area->area_member_id]) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Alamat') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="provinsi" class="col-md-4 col-form-label text-md-end">{{ __('Provinsi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi">
                                            @foreach($provinsi as $prov)
                                            <option {{ $area->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->provinsi_id == $prov->provinsi_id ? 'selected' : '' }} value="{{ $prov->provinsi_id }}">{{ $prov->nama_provinsi }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('provinsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kabupaten" class="col-md-4 col-form-label text-md-end">{{ __('Kabupaten')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('kabupaten') is-invalid @enderror" name="kabupaten" id="kabupaten">
                                            @foreach($kabupaten as $kab)
                                            <option {{ $area->desa()->first()->kecamatan()->first()->kabupaten()->first()->kabupaten_id == $kab->kabupaten_id ? 'selected' : '' }} value="{{ $kab->kabupaten_id }}">{{ $kab->nama_kabupaten}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('kabupaten')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kecamatan" class="col-md-4 col-form-label text-md-end">{{ __('Kecamatan')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('kecamatan') is-invalid @enderror" name="kecamatan" id="kecamatan">
                                            @foreach($kecamatan as $kec)
                                            <option {{ $area->desa()->first()->kecamatan()->first()->kecamatan_id == $kec->kecamatan_id ? 'selected' : '' }} value="{{ $kec->kecamatan_id }}">{{ $kec->nama_kecamatan}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('kecamatan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="desa" class="col-md-4 col-form-label text-md-end">{{ __('Desa')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('desa') is-invalid @enderror" name="desa" id="desa">
                                            @foreach($desa as $des)
                                            <option {{ $area->desa()->first()->kecamatan()->first()->desa()->first()->desa_id == $des->desa_id ? 'selected' : '' }} value="{{ $des->desa_id }}">{{ $des->nama_desa}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('desa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="kode_pos" class="col-md-4 col-form-label text-md-end">{{ __('Kode Pos')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="kode_pos" type="text"
                                                class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos"
                                                value="{{ $area->kode_pos }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('kode_pos')
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
                                            <input id="alamat" type="text"
                                                class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                                value="{{ $area->alamat }}" autocomplete="name"
                                                autofocus>
                                        
                                        @error('alamat')
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
                                        <a type="button" href="{{ route('master.anggota.list.area.show',[$anggota->informasi_akun_id, $area->area_member_id]) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
