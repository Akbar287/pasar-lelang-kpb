@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Jaminan Komoditas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.komoditas.index', $detailJaminan->detail_jaminan_id) }}">Komoditas</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Penerimaan Jaminan Komoditas</h2>
    <p class="section-lead">
        Detail data Penerimaan Jaminan Komoditas anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Penerimaan Jaminan Komoditas') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="komoditi" class="col-md-4 col-form-label text-md-end">{{ __('Komoditi')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="komoditi" type="text" readonly
                                            class="form-control" name="komoditi"
                                            value="{{ $komoditas->komoditi }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="kadaluarsa" class="col-md-4 col-form-label text-md-end">{{ __('Kadaluarsa')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="kadaluarsa" type="date" readonly
                                            class="form-control" name="kadaluarsa"
                                            value="{{ $komoditas->kadaluarsa }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="kuantitas" class="col-md-4 col-form-label text-md-end">{{ __('Kuantitas')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="kuantitas" type="text" readonly
                                            class="form-control thousand-style" name="kuantitas"
                                            value="{{ $komoditas->kuantitas }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="unit" class="col-md-4 col-form-label text-md-end">{{ __('Unit')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="unit" type="text"
                                            class="form-control" name="unit" readonly
                                            value="{{ $komoditas->unit }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nilai_perkiraan" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Perkiraan')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="nilai_perkiraan" type="text" readonly
                                            class="form-control thousand-style" name="nilai_perkiraan"
                                            value="{{ $komoditas->nilai_perkiraan }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="haircut" class="col-md-4 col-form-label text-md-end">{{ __('Haircut')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="haircut" type="text" readonly
                                            class="form-control thousand-style" name="haircut"
                                            value="{{ $komoditas->haircut }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nilai_penyesuaian" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Penyesuaian')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="nilai_penyesuaian" type="text" readonly
                                            class="form-control thousand-style" name="nilai_penyesuaian"
                                            value="{{ $komoditas->nilai_penyesuaian }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="lokasi" class="col-md-4 col-form-label text-md-end">{{ __('Lokasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="lokasi" class="form-control" readonly name="lokasi" type="text" cols="30" rows="10">{{ $komoditas->lokasi }}</textarea>
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.komoditas.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.komoditas.edit', [$detailJaminan->detail_jaminan_id, $komoditas->registrasi_komoditas_jaminan_id]) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('administrasi.jaminan.penerimaan.komoditas.destroy', [$detailJaminan->detail_jaminan_id, $komoditas->registrasi_komoditas_jaminan_id]) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Data Penerimaan Jaminan Komoditas akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

