@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Admin</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.admin') }}">Admin</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Admin</h2>
    <p class="section-lead">
        Detail data Admin anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Admin') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="nik" class="col-md-4 col-form-label text-md-end">{{ __('NIK')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nik" readonly type="text"
                                        class="form-control" name="nik"
                                        value="{{ $admin->member()->first()->ktp()->first()->nik }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="nik" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nik" readonly type="text"
                                        class="form-control" name="nik"
                                        value="{{ $admin->member()->first()->ktp()->first()->nama }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="nik" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="nik" readonly type="text"
                                        class="form-control" name="nik"
                                        value="{{ $admin->is_aktif ? 'Aktif' : 'Non-Aktif' }}" />
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
                                        <a type="button" href="{{ route('konfigurasi.admin') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        @if($admin->is_aktif) 
                                        <form action="{{ route('konfigurasi.admin.status_nonaktif', $admin->admin_id) }}" method="POST">@csrf @method('put')
                                            <button type="submit" onclick="return confirm('Non-Aktifkan User ini!\n Lanjutkan?')" title="Non-Aktifkan" class="btn btn-warning"><i class="fas fa-times"></i> Non-Aktifkan</button>
                                        </form>
                                        @else 
                                        <form action="{{ route('konfigurasi.admin.status_aktif', $admin->admin_id) }}" method="POST">@csrf @method('put')
                                            <button type="submit" onclick="return confirm('Aktifkan User ini!\n Lanjutkan?')" title="Aktifkan" class="btn btn-success mr-2"><i class="fas fa-check"></i> Aktifkan</button>
                                        </form>
                                        @endif
                                        <form action="{{ route('konfigurasi.admin.destroy', $admin->admin_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Status Admin akan dihapus dari User ini!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger ml-2"><i class="fas fa-trash"></i> Hapus Status Admin</button>
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

