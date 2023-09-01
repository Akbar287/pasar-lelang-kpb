@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Rekening Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list') }}">List</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list.show', $anggota->informasi_akun_id) }}">Detail Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list.rekening.index', $anggota->informasi_akun_id) }}">Rekening Bank</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Rekening Bank</h2>
    <p class="section-lead">
        Detail data Rekening Bank.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Rekening Bank') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="bank_id" class="col-md-4 col-form-label text-md-end">{{ __('Bank')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="cabang" type="text" readonly
                                            class="form-control @error('cabang') is-invalid @enderror" name="cabang"
                                            value="{{ $rekening->bank()->first()->nama_bank }}" autocomplete="name"
                                            autofocus>
                                    
                                    @error('bank_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_rekening" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="nomor_rekening" type="text" readonly
                                            class="form-control @error('nomor_rekening') is-invalid @enderror" name="nomor_rekening"
                                            value="{{ $rekening->nomor_rekening }}" autocomplete="name"
                                            autofocus>
                                    
                                    @error('nomor_rekening')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nama_pemilik" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pemilik Rekening')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="nama_pemilik" type="text" readonly
                                            class="form-control @error('nama_pemilik') is-invalid @enderror" name="nama_pemilik"
                                            value="{{ $rekening->nama_pemilik }}" autocomplete="name"
                                            autofocus>
                                    
                                    @error('nama_pemilik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="cabang" class="col-md-4 col-form-label text-md-end">{{ __('Cabang')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="cabang" type="text" readonly
                                            class="form-control @error('cabang') is-invalid @enderror" name="cabang"
                                            value="{{ $rekening->cabang }}" autocomplete="name"
                                            autofocus>
                                    
                                    @error('cabang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Mata Uang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="mata_uang" type="text" readonly
                                            class="form-control @error('mata_uang') is-invalid @enderror" name="mata_uang"
                                            value="{{ $rekening->mata_uang }}" autocomplete="name"
                                            autofocus>
                                    
                                    @error('mata_uang')
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
                                    <a type="button" href="{{ route('master.anggota.list.rekening.index', $anggota->informasi_akun_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('master.anggota.list.rekening.edit', [$anggota->informasi_akun_id, $rekening->rekening_bank_id]) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <form action="{{ route('master.anggota.list.rekening.destroy', [$anggota->informasi_akun_id, $rekening->rekening_bank_id]) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('Data Rekening Bank akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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
