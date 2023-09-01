@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Daftar Anggota</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list') }}">Daftar Anggota</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Daftar Anggota</h2>
    <p class="section-lead">
        Detail data Daftar Anggota anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('master.anggota.list.suspend', $anggota->informasi_akun_id) }}" method="post" enctype="multipart/form-data">@csrf
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Informasi Keuangan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="suspend_type_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Suspend')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('suspend_type_id') is-invalid @enderror" name="suspend_type_id" id="suspend_type_id">
                                            @foreach($suspends as $suspend)
                                            <option {{ old('suspend_type_id') == $suspend->suspend_type_id ? 'selected' : '' }} value="{{ $suspend->suspend_type_id }}">{{ $suspend->nama_suspend }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('suspend_type_id')
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
                                        <textarea id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" cols="30" rows="10">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')
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
                                        <a type="button" href="{{ route('master.anggota.list') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                         <button type="submit" onclick="return confirm('Anggota akan di suspend!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-user-times"></i> Suspend</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

