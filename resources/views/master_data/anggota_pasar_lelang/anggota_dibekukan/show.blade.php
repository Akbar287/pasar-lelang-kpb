@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Anggota Dibekukan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.dibekukan') }}">Detail Anggota Dibekukan</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Detail Anggota Dibekukan</h2>
    <p class="section-lead">
        Detail data Detail Anggota Dibekukan anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('master.anggota.dibekukan.store', [$anggota->informasi_akun_id, $suspend->suspend_id]) }}" method="POST">@csrf
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Pilihan') }}</h4>
                    <div class="card-header-action">
                        @if(!is_null($anggota->member()->first()))
                            @if($anggota->member()->first()->status_member()->first()->nama_status == 'Aktif')
                            <div class="badge badge-success">{{ $anggota->member()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->member()->first()->status_member()->first()->nama_status == 'Calon Anggota')
                            <div class="badge badge-warning">{{ $anggota->member()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->member()->first()->status_member()->first()->nama_status == 'Suspend')
                            <div class="badge badge-danger">{{ $anggota->member()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->member()->first()->status_member()->first()->nama_status == 'Tidak Aktif')
                            <div class="badge badge-dark">{{ $anggota->member()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                        @else 
                            @if($anggota->lembaga()->first()->status_member()->first()->nama_status == 'Aktif')
                            <div class="badge badge-success">{{ $anggota->lembaga()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->lembaga()->first()->status_member()->first()->nama_status == 'Calon Anggota')
                            <div class="badge badge-warning">{{ $anggota->lembaga()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->lembaga()->first()->status_member()->first()->nama_status == 'Suspend')
                            <div class="badge badge-danger">{{ $anggota->lembaga()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                            @if($anggota->lembaga()->first()->status_member()->first()->nama_status == 'Tidak Aktif')
                            <div class="badge badge-dark">{{ $anggota->lembaga()->first()->status_member()->first()->nama_status }}</div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="nama" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nama" type="text" readonly
                                        class="form-control" name="nama"
                                        value="{{ !is_null($suspend->verified_log()->first()->informasi_akun()->first()->lembaga()->first()) ? $suspend->verified_log()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $suspend->verified_log()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}" autocomplete="name" autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_suspend" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Suspend')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="tanggal_suspend" type="text" readonly
                                        class="form-control" name="tanggal_suspend"
                                        value="{{ $suspend->tanggal_suspend }}" autocomplete="name" autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan_suspend" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan Di Suspend')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="keterangan_suspend" readonly class="form-control" name="keterangan_suspend" cols="30" rows="10">{{ $suspend->keterangan ?? "Tidak Ada Keterangan" }}</textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Alasan Di Reaktivasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="keterangan" class="form-control" name="keterangan" cols="30" rows="10">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Pilihan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-0">
                                    <div class="col-md-10  d-flex align-items-end">
                                        <a type="button" href="{{ route('master.anggota.dibekukan') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            <button type="submit" onclick="return confirm('Anggota akan reaktivasi!\n Lanjutkan?')" title="Reaktivasi" class="btn btn-success"><i class="fas fa-refresh"></i> Reaktivasi</button>
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
</div>
@endsection
