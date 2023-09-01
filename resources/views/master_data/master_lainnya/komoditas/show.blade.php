@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Komoditas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lainnya</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain.komoditas') }}">Komoditas</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Komoditas</h2>
    <p class="section-lead">
        Detail data Komoditas anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Komoditas') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_komoditas_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Komoditas')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="jenis_komoditas_id" type="text" readonly
                                        class="form-control" name="jenis_komoditas_id"
                                        value="{{ $komoditas->jenis_komoditas_id }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nama_komoditas" class="col-md-4 col-form-label text-md-end">{{ __('Nama Komoditas')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nama_komoditas" type="text" readonly
                                        class="form-control" name="nama_komoditas"
                                        value="{{ $komoditas->nama_komoditas }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="satuan_ukuran" class="col-md-4 col-form-label text-md-end">{{ __('Satuan Ukur')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="satuan_ukuran" type="text" readonly
                                        class="form-control" name="satuan_ukuran"
                                        value="{{ $komoditas->satuan_ukuran }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="inisiasi" class="col-md-4 col-form-label text-md-end">{{ __('Digunakan Inisiasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="inisiasi" type="text" readonly
                                        class="form-control" name="inisiasi"
                                        value="{{ $komoditas->inisiasi ? 'Ya' : "Tidak" }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="kadaluarsa" class="col-md-4 col-form-label text-md-end">{{ __('Termasuk Komoditas yang Kadaluarsa')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="inisiasi" type="text" readonly
                                        class="form-control" name="inisiasi"
                                        value="{{ $komoditas->kadaluarsa ? 'Ya' : "Tidak" }}" autocomplete="name"
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
                                        <a type="button" href="{{ route('master.lain.komoditas') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('master.lain.komoditas.edit', $komoditas->komoditas_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('master.lain.komoditas.destroy', $komoditas->komoditas_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Komoditas akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

