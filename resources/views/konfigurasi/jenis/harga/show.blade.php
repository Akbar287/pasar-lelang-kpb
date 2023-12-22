@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jenis Harga</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis') }}">Jenis</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis.harga') }}">Harga</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Jenis Harga</h2>
    <p class="section-lead">
        Detail data Jenis Harga anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Jenis Harga') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_jenis_harga" class="col-md-4 col-form-label text-md-end">{{ __('Nama Jenis Harga')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nama_jenis_harga" readonly type="text"
                                        class="form-control" name="nama_jenis_harga"
                                        value="{{ $jenisHarga->nama_jenis_harga }}" />
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
                                        <a type="button" href="{{ route('konfigurasi.jenis.harga') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('konfigurasi.jenis.harga.edit', $jenisHarga->jenis_harga_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('konfigurasi.jenis.harga.destroy', $jenisHarga->jenis_harga_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Jenis Harga akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

