@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Perjanjian Jual Beli</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.laporan') }}">Laporan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.laporan.perjanjian_jual_beli') }}">Perjanjian Jual Beli</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Perjanjian Jual Beli</h2>
    <p class="section-lead">
        Detail data Perjanjian Jual Beli anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Perjanjian Jual Beli') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="key" class="col-md-4 col-form-label text-md-end">{{ __('Pasal') }}</label>

                                <div class="col-md-6">
                                    <input id="key" type="text" readonly class="form-control" name="key" value="{{ $perjanjianJualBeliPasal->key }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="value" class="col-md-4 col-form-label text-md-end">{{ __('Isi Pasal') }}</label>
        
                                <div class="col-md-6">
                                    <textarea id="value" class="form-control" readonly name="value" cols="30" rows="10">{{ $perjanjianJualBeliPasal->value }}</textarea>
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
                                        <a type="button" href="{{ route('konfigurasi.laporan.perjanjian_jual_beli') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('konfigurasi.laporan.perjanjian_jual_beli.edit', $perjanjianJualBeliPasal->perjanjian_jual_beli_pasal_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('konfigurasi.laporan.perjanjian_jual_beli.destroy', $perjanjianJualBeliPasal->perjanjian_jual_beli_pasal_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Pasal akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

