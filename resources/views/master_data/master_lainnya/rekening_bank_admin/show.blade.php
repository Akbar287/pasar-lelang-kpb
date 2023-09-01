@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Rekening Bank Admin</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lainnya</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain.rekening') }}">Rekening Bank Admin</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Rekening Bank Admin</h2>
    <p class="section-lead">
        Detail data Rekening Bank Admin anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Rekening Bank Admin') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="penyelenggara_pasar_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara Pasar Lelang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="penyelenggara_pasar_lelang_id" type="text" readonly
                                        class="form-control @error('penyelenggara_pasar_lelang_id') is-invalid @enderror" name="penyelenggara_pasar_lelang_id"
                                        value="{{ $rekening->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="bank_id" class="col-md-4 col-form-label text-md-end">{{ __('Nama Bank')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="bank_id" type="text" readonly
                                        class="form-control @error('bank_id') is-invalid @enderror" name="bank_id"
                                        value="{{ $rekening->bank()->first()->nama_bank }}" autocomplete="name"
                                        autofocus>
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
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nama_pemilik" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pemilik')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nama_pemilik" type="text" readonly
                                        class="form-control @error('nama_pemilik') is-invalid @enderror" name="nama_pemilik"
                                        value="{{ $rekening->nama_pemilik }}" autocomplete="name"
                                        autofocus>
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
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Aktif')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="mata_uang" type="text" readonly
                                        class="form-control @error('mata_uang') is-invalid @enderror" name="mata_uang"
                                        value="{{ $rekening->mata_uang }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nilai_awal" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Awal')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="nilai_awal" type="text" readonly
                                            class="form-control thousand-style  @error('nilai_awal') is-invalid @enderror" name="nilai_awal"
                                            value="{{ number_format($rekening->nilai_awal, 2, ".", ',') }}" autocomplete="name"
                                            autofocus>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="saldo" class="col-md-4 col-form-label text-md-end">{{ __('Saldo')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="saldo" type="text" readonly
                                            class="form-control thousand-style  @error('saldo') is-invalid @enderror" name="saldo"
                                            value="{{ number_format($rekening->saldo, 2, '.', ',') }}" autocomplete="name"
                                            autofocus>
                                    </div>
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
                                        <a type="button" href="{{ route('master.lain.rekening') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('master.lain.rekening.edit', $rekening->rekening_bank_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('master.lain.rekening.destroy', $rekening->rekening_bank_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Rekening Bank Admin akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

