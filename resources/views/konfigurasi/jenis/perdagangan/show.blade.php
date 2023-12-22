@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jenis Perdagangan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis') }}">Jenis</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.jenis.perdagangan') }}">Perdagangan</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Jenis Perdagangan</h2>
    <p class="section-lead">
        Detail data Jenis Perdagangan anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Jenis Perdagangan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_perdagangan" class="col-md-4 col-form-label text-md-end">{{ __('Nama Perdagangan')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nama_perdagangan" readonly type="text"
                                        class="form-control" name="nama_perdagangan"
                                        value="{{ $jenisPerdagangan->nama_perdagangan }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="is_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="is_aktif" readonly type="text"
                                        class="form-control" name="is_aktif"
                                        value="{{ $jenisPerdagangan->is_aktif ? 'Aktif' : "Tidak Aktif" }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" readonly name="nama_perdagangan" cols="30" rows="10">{{ $jenisPerdagangan->keterangan }}</textarea>
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
                                        <a type="button" href="{{ route('konfigurasi.jenis.perdagangan') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('konfigurasi.jenis.perdagangan.edit', $jenisPerdagangan->jenis_perdagangan_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('konfigurasi.jenis.perdagangan.destroy', $jenisPerdagangan->jenis_perdagangan_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Jenis Perdagangan akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

