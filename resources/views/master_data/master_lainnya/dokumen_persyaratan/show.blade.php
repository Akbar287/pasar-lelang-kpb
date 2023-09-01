@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jenis Dokumen</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lainnya</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain.dokumen_persyaratan') }}">Jenis Dokumen</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Jenis Dokumen</h2>
    <p class="section-lead">
        Detail data Jenis Dokumen anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Jenis Dokumen') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_jenis" class="col-md-4 col-form-label text-md-end">{{ __('Nama Jenis')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nama_jenis" type="text" readonly
                                        class="form-control @error('nama_jenis') is-invalid @enderror" name="nama_jenis"
                                        value="{{ $jenisDokumen->nama_jenis }}" autocomplete="name"
                                        autofocus>
        
                                    @error('nama_jenis')
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
                                    <textarea id="keterangan" type="text" readonly class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" cols="30" rows="10">{{ $jenisDokumen->keterangan }}</textarea>

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
                                    <a type="button" href="{{ route('master.lain.dokumen_persyaratan') }}" class="btn btn-primary mr-2"><i class="fasfa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('master.lain.dokumen_persyaratan.edit', $jenisDokumen->jenis_dokumen_id) }}"class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <form action="{{ route('master.lain.dokumen_persyaratan.destroy', $jenisDokumen->jenis_dokumen_id) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('Jenis Dokumen akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

