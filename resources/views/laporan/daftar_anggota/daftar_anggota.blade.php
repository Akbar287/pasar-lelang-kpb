@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Laporan Daftar Anggota</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('laporan') }}">Laporan</a></div>
        <div class="breadcrumb-item">Laporan Daftar Anggota</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Laporan Daftar Anggota</h2>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Laporan Daftar Anggota ') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan.daftar_anggota') }}" method="post"> @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="chooser" class="col-md-4 col-form-label text-md-end">{{ __('Pencarian Berdasarkan')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('chooser') is-invalid @enderror" name="chooser" id="chooser">
                                            <option value="1">Perorangan</option>
                                            <option value="2">Semua Anggota</option>
                                            <option value="3">Lembaga</option>
                                            <option value="4">Semua Lembaga</option>
                                        </select>
                                        
                                        @error('chooser')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center choose-perorangan">
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
                                
                                <div class="row mb-3 justify-content-center choose-lembaga d-none">
                                    <label for="lembaga_id" class="col-md-4 col-form-label text-md-end">{{ __('Lembaga')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('lembaga_id') is-invalid @enderror" name="lembaga_id" id="lembaga_id">
                                        </select>
                                        
                                        @error('lembaga_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center choose-semua d-none">
                                    <label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('status') is-invalid @enderror" name="status" id="status">
                                            <option value="semua">Semua</option>
                                            @foreach($status as $s)
                                            <option value="{{ $s->status_member_id }}">{{ $s->nama_status }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('status')
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
