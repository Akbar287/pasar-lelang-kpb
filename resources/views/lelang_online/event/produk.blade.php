@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Produk Event Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online') }}">Lelang Online</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event') }}">Event</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event.show', $event->lelang_sesi_online_id) }}">Detail</a></div>
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
                    <h4>{{ __('List Produk Event Lelang Online') }}</h4>
                    <div class="card-header-action">
                        {{ $data->count() }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        @if($data->count() > 0)
                        @foreach($data as $dt)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="{{ asset('storage/produk/' . (empty($dt->dokumen_produk()->where('is_gambar_utama', true)->first()) ? 'default.png' : $dt->dokumen_produk()->where('is_gambar_utama', true)->first()->nama_file)) }}" style='background-image: url("{{ asset('storage/produk/' . (empty($dt->dokumen_produk()->where('is_gambar_utama', true)->first()) ? 'default.png' : $dt->dokumen_produk()->where('is_gambar_utama', true)->first()->nama_file)) }}")'></div>
                                    <div class="article-title">
                                        <h2><a href="{{ route('online.event.produk.show', [$event->lelang_sesi_online_id, $dt->lelang_id]) }}">{{ $dt->judul }}</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <div><i class="fas fa-bookmark"></i> {{ $dt->kontrak()->first()->komoditas()->first()->nama_komoditas }}</div>
                                    <div><i class="fas fa-file"></i> {{ $dt->kontrak()->first()->kontrak_kode }}</div>
                                    <div><i class="fas fa-cubes"></i> {{ number_format($dt->kuantitas, 0, ".", ",") . ' ' . $dt->kontrak()->first()->komoditas()->first()->satuan_ukuran }}</div>
                                    <div><i class="fas fa-map-marker"></i> {{ $dt->lokasi_penyerahan }}</div>
                                    <div class="article-cta">                           
                                        <a href="{{ route('online.event.produk.show', [$event->lelang_sesi_online_id, $dt->lelang_id]) }}" class="btn btn-primary btn-sm">Lihat</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {!! $data->links() !!}
                        </div>
                        @else 
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <h4 class="text-center">Tidak ada Produk Lelang</h4>
                        </div>
                        @endif
                    </div>          
                    <a href="{{ route('online.event.show', $event->lelang_sesi_online_id) }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
