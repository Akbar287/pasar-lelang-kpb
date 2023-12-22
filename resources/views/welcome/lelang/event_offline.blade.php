@extends('layouts.app-welcome')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('welcome.lelang') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>
<div class="row mb-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ __('Detail Event Lelang') }}</h4>
                <div class="card-header-action">
                    @if ($event->status_event_lelang()->first()->nama_status == 'Lelang Baru')
                        <div class="badge badge-primary">Lelang Baru</div>
                    @elseif($event->status_event_lelang()->first()->nama_status == 'Sinkronisasi Inisiasi Jual')
                        <div class="badge badge-info">Sinkronisasi Inisiasi Jual</div>
                    @elseif($event->status_event_lelang()->first()->nama_status == 'Sinkronisasi Anggota Lelang')
                        <div class="badge badge-warning">Sinkronisasi Anggota Lelang</div>
                    @elseif($event->status_event_lelang()->first()->nama_status == 'Lelang Berlangsung')
                        <div class="badge badge-success">Lelang Berlangsung</div>
                    @elseif($event->status_event_lelang()->first()->nama_status == 'Selesai')
                        <div class="badge badge-secondary">Selesai</div>
                    @else
                        <div class="badge badge-danger">No Status</div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-3 justify-content-center">
                            <label for="offline_profile_id" class="col-md-4 col-form-label text-md-end">{{ __('Offline Profile')
                                }}</label>

                            <div class="col-md-6">
                                    <input id="offline_profile_id" type="text"
                                        class="form-control" name="user_id" readonly
                                        value="{{ $event->offline_profile()->first()->nama_profile }}">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label for="event_kode" class="col-md-4 col-form-label text-md-end">{{ __('Kode Event')
                                }}</label>

                            <div class="col-md-6">
                                    <input id="event_kode" type="text" readonly
                                        class="form-control" name="event_kode"
                                        value="{{ $event->event_kode }}">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <label for="nama_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Nama Lelang')
                                }}</label>

                            <div class="col-md-6">
                                    <input id="nama_lelang" type="text" readonly
                                        class="form-control" name="nama_lelang"
                                        value="{{ $event->nama_lelang }}">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <label for="tanggal_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Lelang')
                                }}</label>

                            <div class="col-md-6">
                                    <input id="tanggal_lelang" type="date" readonly
                                        class="form-control" name="tanggal_lelang"
                                        value="{{ $event->tanggal_lelang }}">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <label for="jam_mulai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Mulai')
                                }}</label>

                            <div class="col-md-6">
                                    <input id="jam_mulai" type="time" readonly
                                        class="form-control" name="jam_mulai"
                                        value="{{ $event->jam_mulai }}">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <label for="jam_selesai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Selesai')
                                }}</label>

                            <div class="col-md-6">
                                <input id="jam_selesai" type="time" readonly
                                    class="form-control" name="jam_selesai"
                                    value="{{ $event->jam_selesai }}">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <label for="lokasi" class="col-md-4 col-form-label text-md-end">{{ __('Lokasi')
                                }}</label>

                            <div class="col-md-6">
                                <textarea id="lokasi" readonly class="form-control" name="lokasi" cols="10" rows="5">{{ $event->lokasi }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <label for="ketua_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Ketua Lelang')
                                }}</label>

                            <div class="col-md-6">
                                <input id="ketua_lelang" type="text" readonly
                                    class="form-control" name="ketua_lelang"
                                    value="{{ $event->ketua_lelang }}">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                }}</label>

                            <div class="col-md-6">
                                    <textarea id="keterangan" readonly class="form-control" name="keterangan" cols="10" rows="5">{{ $event->keterangan }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <label for="is_open" class="col-md-4 col-form-label text-md-end">{{ __('Terbuka Untuk Penjual')
                                }}</label>

                            <div class="col-md-6">
                                <input id="is_open" type="text" readonly
                                    class="form-control" name="is_open"
                                    value="{{ $event->is_open ? 'Aktif' : 'Tidak Aktif' }}">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <label for="is_online" class="col-md-4 col-form-label text-md-end">{{ __('Hybrid')
                                }}</label>

                            <div class="col-md-6">
                                <input id="is_online" type="text" readonly
                                    class="form-control" name="is_online"
                                    value="{{ $event->is_online ? 'Online - Offline' : 'Offline' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ __('Produk Lelang') }}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    @if($event->lelang()->count() > 0)
                        @foreach($event->lelang()->get() as $ls)
                        <div class=" col-sm-12 col-md-6 col-lg-3 mb-2">
                            <div class="card">
                                <img class="card-img-top" src="{{ !is_null($ls->dokumen_produk()->where('is_gambar_utama', true)->first()) ? asset('storage/produk/' .$ls->dokumen_produk()->where('is_gambar_utama', true)->first()->nama_file) : asset('storage/produk/default.png') }}" height="200" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $ls->judul }}</h5>
                                    <p class="card-text">{{ $ls->spesifikasi_produk }}</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Rp. {{ number_format($ls->harga_awal,0, ".", ",") }}</li>
                                    <li class="list-group-item">Rp. {{ number_format($ls->kelipatan_penawaran,0, ".", ",") }}</li>
                                    <li class="list-group-item">{{ $ls->lokasi_penyerahan }}</li>
                                    <li class="list-group-item">{{ number_format($ls->kuantitas, 0, ".", ",") . ' ('. $ls->kontrak()->first()->komoditas()->first()->satuan_ukuran .')' }}</li>
                                </ul>
                                <div class="card-footer">
                                    <a href="{{ route('welcome.event_offline_lelang', [$event->event_lelang_id, $ls->lelang_id]) }}" class="btn btn-primary btn-block">Lihat</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <p>Tidak ada Produk Lelang</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
