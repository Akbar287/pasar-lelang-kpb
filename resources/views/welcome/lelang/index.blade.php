@extends('layouts.app-welcome')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="row mb-2">
            <div class="col-12 col-sm-12 col-md-4">
                <div class="card">
                    <div class="card-header">Jadwal Sesi Lelang Online</div>
                    <div class="card-body">
                        @if($masterSesiLelang->count() > 0)
                        <ul>
                            @foreach($masterSesiLelang as $s)
                            <li>{{ $s->sesi . ' (' . $s->jam_mulai .'-'. $s->jam_berakhir .')' }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-8">
                @if(App\Models\Carousel::where('page', 'Lelang')->count() > 0)
                <div id="carouselWelcome" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach(App\Models\Carousel::where('page', 'Lelang')->get() as $c)
                        <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                            <img class="d-block w-100" src="{{ asset('storage/carousel/'.$c->image_src ) }}" height="350" alt="{{ $c->title }}">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $c->title }}</h5>
                                <p>{{ $c->subtitle }}</p>
                            </div>
                        </div>
                        @endforeach
                        @if(App\Models\Carousel::where('page', 'Lelang')->count() > 1)
                        <a class="carousel-control-prev" href="#carouselWelcome" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carouselWelcome" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                Lelang Online {{ Carbon\Carbon::now()->format('d F Y') }}
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="row mb-2">
            @if($lso->count() > 0)
                @foreach($lso as $ls)
                <div class=" col-sm-12 col-md-6 col-lg-3 mb-2">
                    <div class="card">
                        <img class="card-img-top" src="{{ !is_null($ls->lelang()->first()->dokumen_produk()->where('is_gambar_utama', true)->first()) ? asset('storage/produk/' .$ls->lelang()->first()->dokumen_produk()->where('is_gambar_utama', true)->first()->nama_file) : asset('storage/produk/default.png') }}" height="200" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ls->lelang()->first()->judul }}</h5>
                            <p class="card-text">{{ $ls->lelang()->first()->spesifikasi_produk }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">{{ $ls->master_sesi_lelang()->first()->sesi . '( '.$ls->master_sesi_lelang()->first()->jam_mulai. ' ' .$ls->master_sesi_lelang()->first()->jam_berakhir .')' }}</li>
                            <li class="list-group-item">Rp. {{ number_format($ls->lelang()->first()->harga_awal,0, ".", ",") }}</li>
                            <li class="list-group-item">Rp. {{ number_format($ls->lelang()->first()->kelipatan_penawaran,0, ".", ",") }}</li>
                            <li class="list-group-item">{{ $ls->lelang()->first()->lokasi_penyerahan }}</li>
                            <li class="list-group-item">{{ number_format($ls->lelang()->first()->kuantitas, 0, ".", ",") . ' ('. $ls->lelang()->first()->kontrak()->first()->komoditas()->first()->satuan_ukuran .')' }}</li>
                        </ul>
                        <div class="card-footer">
                            <a href="{{ route('welcome.online_lelang', $ls->lelang_id) }}" class="btn btn-primary btn-block">Lihat</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <p>Tidak ada Produk Lelang</p>
            @endif
        </div>
        <div class="row mb-2">
            <div class="col-12">
                {{ $lso->links() }}
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                Lelang Offline
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="row">
        @if($eventLelang->count() > 0)
            @foreach($eventLelang as $el)
            <div class="col-12 col-sm-12 col-md-4 col-lg-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $el->nama_lelang }}</h5>
                        <p class="card-text">{{ $el->is_online ? 'Hybrid' : 'Offline' }}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">{{ $el->tanggal_lelang }}</li>
                        <li class="list-group-item">{{ $el->jam_mulai. ' - ' .$el->jam_selesai }}</li>
                        <li class="list-group-item">{{ $el->lokasi }}</li>
                        <li class="list-group-item">{{ $el->ketua_lelang }}</li>
                    </ul>
                    <div class="card-footer">
                        <a href="{{ route('welcome.event_offline', $el->event_lelang_id) }}" class="btn btn-primary btn-block">Lihat</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <p>Tidak Ada Event lelang Offline</p>
        @endif
        </div>
    </div>
    {{-- <div class="col-12 mb-4"> --}}
        {{-- <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            @if($masterSesiLelang->count() > 0)
            @foreach($masterSesiLelang as $s)
            <li class="nav-item">
                <a class="nav-link @if($loop->iteration == 1) active @endif" id="{{ $s->sesi }}-tab" data-toggle="tab" href="#{{ $s->sesi }}" role="tab">{{ $s->sesi }}</a>
            </li>
            @endforeach
            @endif
          </ul>
          <div class="tab-content" id="pills-tabContent">
            @if($masterSesiLelang->count() > 0)
            @foreach($masterSesiLelang as $s)
                <div class="tab-pane fade show @if($loop->iteration == 1) active @endif" id="{{ $s->sesi }}" role="tabpanel">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">{{ 'Sesi '. $s->sesi . ' ('. $s->jam_mulai . '-'. $s->jam_berakhir .')' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        @if($s->lelang_sesi_online()->where('tanggal', now()->format('Y-m-d'))->count() > 0)
                        @foreach($s->lelang_sesi_online()->where('tanggal', now()->format('Y-m-d'))->get() as $l)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 mb-2 mr-2">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="https://plus.unsplash.com/premium_photo-1699669359390-18fabebcebdb?q=80&w=2064&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Card image cap">
                                <div class="card-body">
                                  <h5 class="card-title">Card title</h5>
                                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                  <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                              </div>
                        </div>
                        @endforeach
                        @else
                        <div class="col-12">
                            <p>Tidak ada Produk yang dijual</p>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
            @endif
        </div> --}}
    {{-- </div> --}}
</div>
@endsection
