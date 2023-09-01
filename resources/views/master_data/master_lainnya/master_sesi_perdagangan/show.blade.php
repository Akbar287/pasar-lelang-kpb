@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Sesi Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lainnya</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain.sesi') }}">Sesi Lelang</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Sesi Lelang</h2>
    <p class="section-lead">
        Detail data Sesi Lelang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Sesi lelang') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="penyelenggara_pasar_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara Pasar Lelang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="jam_berakhir" type="text" readonly
                                        class="form-control @error('jam_berakhir') is-invalid @enderror" name="jam_berakhir"
                                        value="{{ $sesi->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="sesi" class="col-md-4 col-form-label text-md-end">{{ __('Sesi')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="sesi" type="text" readonly
                                        class="form-control" name="sesi"
                                        value="{{ $sesi->sesi }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jam_mulai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Mulai')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="jam_mulai" type="time"
                                        class="form-control" name="jam_mulai" readonly
                                        value="{{ $sesi->jam_mulai }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jam_berakhir" class="col-md-4 col-form-label text-md-end">{{ __('Jam Berakhir')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="jam_berakhir" type="time"
                                    class="form-control" name="jam_berakhir"readonly
                                    value="{{ $sesi->jam_berakhir }}" autocomplete="name"
                                    autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="is_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Aktif')
                                    }}</label>
                                <div class="col-md-6">
                                    <input id="jam_berakhir" type="text" readonly
                                        class="form-control" name="jam_berakhir"
                                        value="{{ $sesi->is_aktif ? 'Aktif' : "Tidak Aktif" }}" autocomplete="name"
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
                                        <a type="button" href="{{ route('master.lain.sesi') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('master.lain.sesi.edit', $sesi->master_sesi_lelang_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('master.lain.sesi.destroy', $sesi->master_sesi_lelang_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Sesi Lelang akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

