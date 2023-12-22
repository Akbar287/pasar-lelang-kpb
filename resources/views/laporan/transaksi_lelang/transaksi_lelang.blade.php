@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Laporan Transaksi Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('laporan') }}">Laporan</a></div>
        <div class="breadcrumb-item">Laporan Transaksi Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Laporan Transaksi Lelang</h2>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Laporan Transaksi Lelang ') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan.transaksi_lelang') }}" method="post"> @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="input-group mb-2">
                                            <input type="date" value="{{ $date['awal'] }}" class="form-control" id="tanggal_awal" name="tanggal_awal" />
                                            <input type="date" value="{{ $date['akhir'] }}" class="form-control" id="tanggal_akhir" name="tanggal_akhir" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="member_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('member_id') is-invalid @enderror" name="member_id" id="member_id">
                                        </select>
                                        
                                        @error('member_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <div class="col-12 text-center">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-download"></i> Unduh</button>
                                    </div>
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
