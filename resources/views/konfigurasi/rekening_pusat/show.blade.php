@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Role</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.rekening_pusat') }}">Role</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Role</h2>
    <p class="section-lead">
        Detail data Role anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Role') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="bank_id" class="col-md-4 col-form-label text-md-end">{{ __('Bank')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="bank_id" type="text"
                                        class="form-control" readonly name="bank_id"
                                        value="{{ $rekeningPusat->bank()->first()->nama_bank }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_rekening" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nomor_rekening" type="text" readonly
                                        class="form-control " name="nomor_rekening"
                                        value="{{ $rekeningPusat->nomor_rekening }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="cabang" class="col-md-4 col-form-label text-md-end">{{ __('Cabang')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="cabang" type="text" readonly
                                        class="form-control" name="cabang"
                                        value="{{ $rekeningPusat->cabang }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="saldo" class="col-md-4 col-form-label text-md-end">{{ __('Saldo')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="saldo" type="text" readonly
                                        class="form-control thousand-style" name="saldo"
                                        value="{{ $rekeningPusat->saldo }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Mata Uang')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="mata_uang" type="text" readonly
                                        class="form-control" name="mata_uang"
                                        value="{{ $rekeningPusat->mata_uang }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="aktif" class="col-md-4 col-form-label text-md-end">{{ __('Jadikan Utama')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="aktif" type="text" readonly
                                        class="form-control" name="aktif"
                                        value="{{ $rekeningPusat->aktif ? 'Utama' : 'Tidak' }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="status" type="text" readonly
                                        class="form-control" name="status"
                                        value="{{ $rekeningPusat->status ? 'Aktif' : 'Tidak' }}" />
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
                                        <a type="button" href="{{ route('konfigurasi.rekening_pusat') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('konfigurasi.rekening_pusat.edit', $rekeningPusat->rekening_pusat_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('konfigurasi.rekening_pusat.destroy', $rekeningPusat->rekening_pusat_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Rekening_pusat akan dihapus! Pastikan saldo anda Rp. 0 \n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

