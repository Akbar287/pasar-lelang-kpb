@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Deposit</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.saldo') }}">Saldo</a></div>
        <div class="breadcrumb-item">Deposit</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Deposit</h2>
    <p class="section-lead">
        Lihat Deposit anda.
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
                            <a href="{{ route('home.saldo') }}" class="btn btn-primary btn-block">Kembali</a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                            <a href="{{ route('home.saldo.withdraw') }}" class="btn btn-info btn-block">Withdraw</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Deposit') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('home.saldo.deposit_store') }}" method="post" enctype="multipart/form-data">@csrf
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
                                    <label for="gambar" class="col-md-4 col-form-label text-md-end">{{
                                        __('Upload Bukti Deposit')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input type="file" name="gambar" class="custom-file-input" id="gambar">
                                            <label class="custom-file-label" for="gambar">Pilih File</label>
                                        </div>

                                        @error('gambar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <img src="" alt="{{ old("gambar") }}" class="img img-thumbnail img-temporary d-none" style="width: 800px; height: auto">
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
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Informasi Rekening Tujuan') }}</h4>
                </div>
                <div class="card-body">
                    @if($rekeningPusat->count() > 0)
                    <table class="table table-hover table-stripped">
                        <thead>
                            <th>Nama Bank</th>
                            <th>Rekening Bank</th>
                            <th>Nama Pemilik</th>
                        </thead>
                        <tbody>
                            @foreach($rekeningPusat as $rp)
                            <td>{{ $rp->bank()->first()->nama_bank }}</td>
                            <td>{{ $rp->nomor_rekening }}</td>
                            <td>{{ $rp->nama_pemilik }}</td>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
