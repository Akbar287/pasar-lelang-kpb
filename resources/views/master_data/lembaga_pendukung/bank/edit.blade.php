@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga') }}">Lembaga</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga.bank') }}">Bank</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga.bank.show', $bank->bank_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Bank</h2>
    <p class="section-lead">
        Ubah data Bankz.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('master.lembaga.bank.update', $bank->bank_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Bank') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="kode_bank" class="col-md-4 col-form-label text-md-end">{{ __('Kode Bank')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="kode_bank" type="text"
                                            class="form-control @error('kode_bank') is-invalid @enderror" name="kode_bank"
                                            value="{{ $bank->kode_bank }}" autocomplete="name"
                                            autofocus>

                                        @error('kode_bank')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_bank" class="col-md-4 col-form-label text-md-end">{{ __('Nama Bank')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="nama_bank" type="text"
                                            class="form-control @error('nama_bank') is-invalid @enderror" name="nama_bank"
                                            value="{{ $bank->nama_bank }}" autocomplete="name"
                                            autofocus>
            
                                        @error('nama_bank')
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
                                        <a type="button" href="{{ route('master.lembaga.bank.show', $bank->bank_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


