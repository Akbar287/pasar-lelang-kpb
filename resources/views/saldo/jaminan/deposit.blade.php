@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Deposit Jaminan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.saldo.jaminan') }}">Saldo Jaminan</a></div>
        <div class="breadcrumb-item">Deposit Jaminan</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Deposit Jaminan</h2>
    <p class="section-lead">
        Lihat Deposit Jaminan anda.
    </p>
    <div class="row">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Saldo') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4 class="title">Rp. {{ number_format($saldo, 0, ".", ",") }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Total Saldo Jaminan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4 class="title">Rp. {{ number_format(is_null(Auth::user()->informasi_akun()->first()->jaminan()->first()) ? 0 : Auth::user()->informasi_akun()->first()->jaminan()->first()->total_saldo_jaminan, 0, ".", ",") }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Deposit Jaminan') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('home.saldo.deposit_jaminan_store') }}" method="post" enctype="multipart/form-data">@csrf
                        <div class="row">
                            <div class="col-12 col-md-12 ">

                                <div class="row mb-3 justify-content-center">
                                    <label for="jumlah" class="col-md-4 col-form-label text-md-end">{{ __('Jumlah')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-2">
                                            <div class="input-group-append">
                                                <div class="input-group-text">Rp. </div>
                                            </div>

                                            <input id="jumlah" type="text"
                                                class="form-control thousand-style @error('jumlah') is-invalid @enderror" name="jumlah"
                                                value="{{ old("jumlah") }}" />
                                        </div>

                                        @error('jumlah')
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
                                        <textarea id="keterangan" type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" cols="30" rows="10">{{ old("keterangan") }}</textarea>

                                        @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <a href="{{ route('home.saldo.jaminan') }}" type="button" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-plane"></i> Kirim</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
