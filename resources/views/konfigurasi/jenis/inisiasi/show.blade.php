@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jenis Inisiasi</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis') }}">Jenis</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis.inisiasi') }}">Inisiasi</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Jenis Inisiasi</h2>
    <p class="section-lead">
        Detail data Jenis Inisiasi anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Jenis Inisiasi') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_inisiasi" class="col-md-4 col-form-label text-md-end">{{ __('Nama Inisiasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nama_inisiasi" readonly type="text"
                                        class="form-control" name="nama_inisiasi"
                                        value="{{ $jenisInisiasi->nama_inisiasi }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="is_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="is_aktif" readonly type="text"
                                        class="form-control" name="is_aktif"
                                        value="{{ $jenisInisiasi->is_aktif ? 'Aktif' : "Tidak Aktif" }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" readonly name="nama_inisiasi" cols="30" rows="10">{{ $jenisInisiasi->keterangan }}</textarea>
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
                                        <a type="button" href="{{ route('konfigurasi.jenis.inisiasi') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('konfigurasi.jenis.inisiasi.edit', $jenisInisiasi->jenis_inisiasi_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('konfigurasi.jenis.inisiasi.destroy', $jenisInisiasi->jenis_inisiasi_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Jenis Inisiasi akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

