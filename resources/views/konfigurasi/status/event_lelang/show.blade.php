@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Status Event Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.status') }}">Status</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.status.event_lelang') }}">Event Lelang</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Status Event Lelang</h2>
    <p class="section-lead">
        Detail data Status Event Lelang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Status Event Lelang') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_status" class="col-md-4 col-form-label text-md-end">{{ __('Nama Status')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nama_status" readonly type="text"
                                        class="form-control" name="nama_status"
                                        value="{{ $statusEventLelang->nama_status }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="is_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Status Aktif')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="is_aktif" readonly type="text"
                                        class="form-control" name="is_aktif"
                                        value="{{ $statusEventLelang->is_aktif ? 'Aktif' : "Tidak" }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <textarea id="keterangan" readonly class="form-control" name="keterangan" cols="30" rows="10">{{ $statusEventLelang->keterangan }}</textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="icon" class="col-md-4 col-form-label text-md-end">{{ __('Icon')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <textarea id="icon" readonly class="form-control" name="icon" cols="30" rows="10">{{ $statusEventLelang->icon }}</textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="urutan" class="col-md-4 col-form-label text-md-end">{{ __('Urutan')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <textarea id="urutan" readonly class="form-control" name="urutan" cols="30" rows="10">{{ $statusEventLelang->urutan }}</textarea>
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
                                        <a type="button" href="{{ route('konfigurasi.status.event_lelang') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('konfigurasi.status.event_lelang.edit', $statusEventLelang->status_event_lelang_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('konfigurasi.status.event_lelang.destroy', $statusEventLelang->status_event_lelang_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Status Event Lelang akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

