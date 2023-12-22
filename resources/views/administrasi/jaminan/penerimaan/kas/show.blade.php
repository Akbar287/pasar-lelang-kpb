@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Jaminan Kas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.kas.index', $detailJaminan->detail_jaminan_id) }}">Kas</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Penerimaan Jaminan Kas</h2>
    <p class="section-lead">
        Detail data Penerimaan Jaminan Kas anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Penerimaan Jaminan Kas') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="kurs_mata_uang_id" class="col-md-4 col-form-label text-md-end">{{ __('Kurs Mata Uang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="kurs_mata_uang_id" type="text" readonly
                                        class="form-control" name="kurs_mata_uang_id"
                                        value="{{ $kas->kurs_mata_uang()->first()->kode_mata_uang_asal . ' - '. $kas->kurs_mata_uang()->first()->kode_mata_uang_tujuan }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="kode_mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Kode Mata Uang')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="kode_mata_uang" type="text" readonly
                                            class="form-control" name="kode_mata_uang"
                                            value="{{ $kas->kode_mata_uang }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nilai" class="col-md-4 col-form-label text-md-end">{{ __('Nilai')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="nilai" type="text" readonly
                                            class="form-control thousand-style" name="nilai"
                                            value="{{ $kas->nilai }}" />
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
                                            value="{{ $kas->nilai_penyesuaian }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="keterangan" class="form-control" readonly name="keterangan" type="text" cols="30" rows="10">{{ $kas->keterangan }}</textarea>
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.kas.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.kas.edit', [$detailJaminan->detail_jaminan_id, $kas->kas_id]) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('administrasi.jaminan.penerimaan.kas.destroy', [$detailJaminan->detail_jaminan_id, $kas->kas_id]) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Data Penerimaan Jaminan Kas akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

