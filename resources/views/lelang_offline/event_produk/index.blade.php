@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Produk Event Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event') }}">Event</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event.show', $event->event_lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Produk Event Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Produk Event Lelang</h2>
    <p class="section-lead">
        Kelola Produk Event Lelang
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Produk Event Lelang Offline') }}</h4>
                    <div class="card-header-action">
                        {{ $data->count() }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4"></div>
                        <div class="col-12 col-md-4"></div>
                        <div class="col-12 col-md-4"></div>
                    </div>
                    @if($data->count() > 0)
                    <div class="row justify-content-center">
                        @foreach($data as $dt)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="{{ asset('storage/produk/' . (empty($dt->dokumen_produk()->where('is_gambar_utama', true)->first()) ? 'default.png' : $dt->dokumen_produk()->where('is_gambar_utama', true)->first()->nama_file)) }}" style='background-image: url("{{ asset('storage/produk/' . (empty($dt->dokumen_produk()->where('is_gambar_utama', true)->first()) ? 'default.png' : $dt->dokumen_produk()->where('is_gambar_utama', true)->first()->nama_file)) }}")'></div>
                                    <div class="article-title">
                                        <h2><a href="{{ route('offline.event.produk.show', [$event->event_lelang_id, $dt->lelang_id]) }}">{{ $dt->judul }}</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <div><i class="fas fa-bookmark"></i> {{ $dt->kontrak()->first()->komoditas()->first()->nama_komoditas }}</div>
                                    <div><i class="fas fa-file"></i> {{ $dt->kontrak()->first()->kontrak_kode }}</div>
                                    <div><i class="fas fa-cubes"></i> {{ number_format($dt->kuantitas, 0, ".", ",") . ' ' . $dt->kontrak()->first()->komoditas()->first()->satuan_ukuran }}</div>
                                    <div><i class="fas fa-map-marker"></i> {{ $dt->lokasi_penyerahan }}</div>
                                    <div class="article-cta">
                                        @if($dt->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai' || $dt->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == "Transaksi Lelang" ||$dt->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == "Verifikasi Transaksi" ||$dt->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == "Transaksi Selesai" ||$dt->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == "Verifikasi Transaksi Ditolak")
                                        <a href="{{ route('offline.event.produk.show', [$event->event_lelang_id, $dt->lelang_id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-check"></i> Selesai</a>
                                        @else
                                        <a href="{{ route('offline.event.produk.show', [$event->event_lelang_id, $dt->lelang_id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-clock"></i> Menunggu Sesi</a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12 justify-content-center">
                            {!! $data->links() !!}
                        </div>
                    </div>
                        @else
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <h4 class="text-center">Tidak ada Produk Lelang</h4>
                        </div>
                        @endif
                    <a href="{{ route('offline.event.show', $event->event_lelang_id) }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
