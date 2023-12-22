@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Mutu</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.mutu') }}">Mutu</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Mutu</h2>
    <p class="section-lead">
        Detail data Mutu anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Mutu') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_mutu" class="col-md-4 col-form-label text-md-end">{{ __('Nama Mutu')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nama_mutu" readonly type="text"
                                        class="form-control" name="nama_mutu"
                                        value="{{ $mutu->nama_mutu }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="is_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Status Aktif')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="is_aktif" readonly type="text"
                                        class="form-control" name="is_aktif"
                                        value="{{ $mutu->is_aktif ? 'Aktif' : "Tidak" }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <textarea id="keterangan" readonly class="form-control" name="keterangan" cols="30" rows="10">{{ $mutu->keterangan }}</textarea>
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
                                        <a type="button" href="{{ route('konfigurasi.mutu') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('konfigurasi.mutu.edit', $mutu->mutu_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('konfigurasi.mutu.destroy', $mutu->mutu_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Mutu akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

