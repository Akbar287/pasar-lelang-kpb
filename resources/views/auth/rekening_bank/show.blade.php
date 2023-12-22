@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Rekening Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.status') }}">Status</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.status.event_lelang') }}">Event Lelang</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Rekening Bank</h2>
    <p class="section-lead">
        Detail data Rekening Bank anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Rekening Bank') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="bank_id" class="col-md-4 col-form-label text-md-end">{{ __('Nama Bank')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="bank_id" type="text" readonly
                                        class="form-control" name="bank_id"
                                        value="{{ $rekeningBank->bank()->first()->nama_bank }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_rekening" class="col-md-4 col-form-label text-md-end">{{ __('No. Rekening') }}</label>
        
                                <div class="col-md-6">
                                    <input id="nomor_rekening" type="text" readonly
                                        class="form-control" name="nomor_rekening"
                                        value="{{ $rekeningBank->nomor_rekening }}" />
                                </div>
                            </div>
                            
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_pemilik" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pemilik') }}</label>
        
                                <div class="col-md-6">
                                    <input id="nama_pemilik" type="text" readonly
                                        class="form-control" name="nama_pemilik"
                                        value="{{ $rekeningBank->nama_pemilik }}" />
                                </div>
                            </div>
                            
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="cabang" class="col-md-4 col-form-label text-md-end">{{ __('Cabang') }}</label>
        
                                <div class="col-md-6">
                                    <input id="cabang" type="text" readonly
                                        class="form-control" name="cabang"
                                        value="{{ $rekeningBank->cabang }}" />
                                </div>
                            </div>
                            
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Mata Uang') }}</label>
        
                                <div class="col-md-6">
                                    <input id="mata_uang" type="text" readonly
                                        class="form-control" name="mata_uang"
                                        value="{{ $rekeningBank->mata_uang }}" />
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
                                        <a type="button" href="{{ route('home.profil.rekening_bank') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('home.profil.rekening_bank.edit', $rekeningBank->rekening_bank_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('home.profil.rekening_bank.destroy', $rekeningBank->rekening_bank_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Rekening Bank akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

