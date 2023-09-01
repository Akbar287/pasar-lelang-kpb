@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga.bank') }}">Bank</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Bank</h2>
    <p class="section-lead">
        Detail data bank anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
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
                                    <input id="kode_bank" type="text" readonly
                                        class="form-control" name="kode_bank"
                                        value="{{ $bank->kode_bank }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_bank" class="col-md-4 col-form-label text-md-end">{{ __('Nama Bank')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nama_bank" type="text" readonly
                                        class="form-control" name="nama_bank"
                                        value="{{ $bank->nama_bank }}" autocomplete="name"
                                        autofocus>
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
                                    <a type="button" href="{{ route('master.lembaga.bank') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('master.lembaga.bank.edit', $bank->bank_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <form action="{{ route('master.lembaga.bank.destroy', $bank->bank_id) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('Bank akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

