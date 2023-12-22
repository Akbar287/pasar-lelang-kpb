@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Withdraw</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.saldo') }}">Saldo</a></div>
        <div class="breadcrumb-item">Withdraw</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Withdraw</h2>
    <p class="section-lead">
        Lihat Withdraw anda.
    </p>
    <div class="row">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12">
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
                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                            <a href="{{ route('home.saldo.deposit') }}" class="btn btn-primary btn-block">Deposit</a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                            <a href="{{ route('home.saldo') }}" class="btn btn-info btn-block">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Withdraw') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('home.saldo.withdraw_store') }}" method="post" enctype="multipart/form-data">@csrf
                        <div class="row">
                            <div class="col-12 col-md-12 ">
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_rekening" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening')
                                        }}</label>

                                    <div class="col-md-6">
                                        @if(Auth::user()->informasi_akun()->first()->rekening_bank()->count() > 0)
                                        <select name="nomor_rekening" id="nomor_rekening" class="custom-select @error('nomor_rekening') is-invalid @enderror">
                                            @foreach(Auth::user()->informasi_akun()->first()->rekening_bank()->get() as $rb)
                                            <option value="{{ $rb->rekening_bank_id }}">{{ $rb->bank()->first()->nama_bank . ' ('. $rb->nomor_rekening .')' }}</option>
                                            @endforeach
                                        </select>
                                        @else
                                        <p>Nomor Rekening Belum Ada</p>
                                        @endif

                                        @error('nomor_rekening')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jumlah" class="col-md-4 col-form-label text-md-end">{{ __('Jumlah')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-2">
                                            <div class="input-group-append">
                                                <div class="input-group-text">Rp. </div>
                                            </div>

                                            <input id="jumlah" type="text" class="form-control thousand-style @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old("jumlah") }}" />
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
                                    <button type="submit" class="btn btn-success">Kirim</button>
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
