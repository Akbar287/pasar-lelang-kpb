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
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Alamat</h2>
    <p class="section-lead">
        Detail data Alamat.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
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
                                    <input id="provinsi" type="text" readonly
                                            class="form-control" name="provinsi"
                                            value="{{ $area->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->nama_provinsi }}" autocomplete="name"
                                            autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="kabupaten" class="col-md-4 col-form-label text-md-end">{{ __('Kabupaten')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="kabupaten" type="text" readonly
                                            class="form-control" name="kabupaten"
                                            value="{{ $area->desa()->first()->kecamatan()->first()->kabupaten()->first()->nama_kabupaten }}" autocomplete="name"
                                            autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="kecamatan" class="col-md-4 col-form-label text-md-end">{{ __('Kecamatan')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="kecamatan" type="text" readonly
                                            class="form-control" name="kecamatan"
                                            value="{{ $area->desa()->first()->kecamatan()->first()->nama_kecamatan }}" autocomplete="name"
                                            autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="desa" class="col-md-4 col-form-label text-md-end">{{ __('Desa')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="desa" type="text" readonly
                                            class="form-control" name="desa"
                                            value="{{ $area->desa()->first()->nama_desa }}" autocomplete="name"
                                            autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="kode_pos" class="col-md-4 col-form-label text-md-end">{{ __('Kode Pos')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="kode_pos" type="text" readonly
                                            class="form-control" name="kode_pos"
                                            value="{{ $area->kode_pos }}" autocomplete="name"
                                            autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="alamat" type="text" readonly
                                            class="form-control" name="alamat"
                                            value="{{ $area->alamat }}" autocomplete="name"
                                            autofocus>
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
                                    <a type="button" href="{{ route('master.anggota.list.area.index', $anggota->informasi_akun_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('master.anggota.list.area.edit', [$anggota->informasi_akun_id, $area->area_member_id]) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <form action="{{ route('master.anggota.list.area.destroy', [$anggota->informasi_akun_id, $area->area_member_id]) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('Data Alamat akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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
