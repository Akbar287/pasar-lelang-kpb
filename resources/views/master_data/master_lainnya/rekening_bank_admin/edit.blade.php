@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Rekening Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lainnya</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain.rekening') }}">Rekening Bank</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain.rekening.show', $rekening->rekening_bank_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Rekening Bank</h2>
    <p class="section-lead">
        Ubah data Rekening Bank anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('master.lain.rekening.update', $rekening->rekening_bank_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Rekening Bank') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="penyelenggara_pasar_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara Pasar Lelang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('penyelenggara_pasar_lelang_id') is-invalid @enderror" name="penyelenggara_pasar_lelang_id" id="penyelenggara_pasar_lelang_id">
                                            @foreach($penyelenggaraPasarLelang as $ppl)
                                            <option {{ $rekening->informasi_akun()->first()->member()->first()->admin()->first()->penyelenggara_pasar_lelang()->first()->penyelenggara_pasar_lelang_id == $ppl->penyelenggara_pasar_lelang_id ? 'selected' : '' }} value="{{ $ppl->penyelenggara_pasar_lelang_id }}">{{ $ppl->admin()->first()->member()->first()->ktp()->first()->nama }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('penyelenggara_pasar_lelang_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="bank_id" class="col-md-4 col-form-label text-md-end">{{ __('Nama Bank')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('bank_id') is-invalid @enderror" name="bank_id" id="bank_id">
                                            @foreach($banks as $bank)
                                            <option {{ $rekening->bank()->first()->bank_id == $bank->bank_id ? 'selected' : '' }} value="{{ $bank->bank_id }}">{{ $bank->nama_bank }}</option>
                                            @endforeach
                                        </select>
                                        
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
                                        <input id="nomor_rekening" type="text"
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
                                    <label for="nama_pemilik" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pemilik')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nama_pemilik" type="text"
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
                                        <input id="cabang" type="text"
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
                                    <label for="mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Aktif')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('mata_uang') is-invalid @enderror" name="mata_uang" id="mata_uang">
                                            <option {{ $rekening->mata_uang == 'IDR' ? 'selected' : '' }} value="{{ 'IDR' }}">{{ "IDR" }}</option>
                                            <option {{ $rekening->mata_uang == 'USD' ? 'selected' : '' }} value="{{ 'USD' }}">{{ "USD" }}</option>
                                        </select>
            
                                        @error('mata_uang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                                            <input id="nilai_awal" type="text"
                                                class="form-control thousand-style  @error('nilai_awal') is-invalid @enderror" name="nilai_awal[]"
                                                value="{{ explode('.', $rekening->nilai_awal)[0] }}" autocomplete="name"
                                                autofocus>
                                            <div class="input-group-append">
                                                <input id="nilai_awal" type="text"
                                                class="form-control @error('nilai_awal') is-invalid @enderror" name="nilai_awal[]"
                                                value="{{ explode('.', $rekening->nilai_awal)[1] }}" autocomplete="name"
                                                autofocus>
                                            </div>
                                        </div>
                                        @error('nilai_awal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                                                <input id="saldo" type="text"
                                                    class="form-control thousand-style  @error('saldo') is-invalid @enderror" name="saldo[]"
                                                    value="{{ explode('.', $rekening->saldo)[0] }}" autocomplete="name"
                                                    autofocus>
                                                <div class="input-group-append">
                                                    <input id="saldo" type="text"
                                                    class="form-control @error('saldo') is-invalid @enderror" name="saldo[]"
                                                    value="{{ explode('.', $rekening->saldo)[1] }}" autocomplete="name"
                                                    autofocus>
                                                </div>
                                            </div>
            
                                        @error('saldo')
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
                                        <a type="button" href="{{ route('master.lain.rekening.show', $rekening->rekening_bank_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <button type="submit" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


