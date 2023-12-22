@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Area</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil') }}">Profil</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil.area') }}">Area</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Area</h2>
    <p class="section-lead">
        Detail data Area anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Area') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="provinsi_id" class="col-md-4 col-form-label text-md-end">{{ __('Provinsi')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="provinsi_id_id" type="text" readonly
                                        class="form-control" name="provinsi_id_id"
                                        value="{{ $areaMember->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->nama_provinsi }}" />
        
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
                                    <input id="kabupaten_id" type="text" readonly
                                        class="form-control" name="kabupaten_id"
                                        value="{{ $areaMember->desa()->first()->kecamatan()->first()->kabupaten()->first()->nama_kabupaten }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="kecamatan_id" class="col-md-4 col-form-label text-md-end">{{ __('Kecamatan')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="kecamatan_id" type="text" readonly
                                        class="form-control" name="kecamatan_id"
                                        value="{{ $areaMember->desa()->first()->kecamatan()->first()->nama_kecamatan }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="desa_id" class="col-md-4 col-form-label text-md-end">{{ __('Desa')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="desa_id" type="text" readonly
                                        class="form-control" name="desa_id"
                                        value="{{ $areaMember->desa()->first()->nama_desa }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat') }}</label>
        
                                <div class="col-md-6">
                                    <input id="alamat" type="text" readonly
                                        class="form-control" name="alamat"
                                        value="{{ $areaMember->alamat }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="kode_pos" class="col-md-4 col-form-label text-md-end">{{ __('Kode Pos') }}</label>
        
                                <div class="col-md-6">
                                    <input id="kode_pos" type="text" readonly
                                        class="form-control " name="kode_pos"
                                        value="{{ $areaMember->kode_pos }}" />
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
                                        <a type="button" href="{{ route('home.profil.area') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('home.profil.area.edit', $areaMember->area_member_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('home.profil.area.destroy', $areaMember->area_member_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Area akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

