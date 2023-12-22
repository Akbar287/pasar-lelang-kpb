@extends('layouts.app-welcome')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('welcome.event_offline', $event->event_lelang_id) }}" class="btn btn-primary">Kembali</a>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Detail Produk Event') }}</h4>
                <div class="card-header-action">
                    <div class="badge badge-success">{{ $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status }}</div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12 col-sm-12">
                        @if($lelang->dokumen_produk()->join('jenis_dokumen_produk', 'jenis_dokumen_produk.jenis_dokumen_produk_id', 'dokumen_produk.jenis_dokumen_produk_id')->where('jenis_dokumen_produk.nama_jenis', 'Gambar')->count() > 0)
                        <div id="carouselWelcome" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($lelang->dokumen_produk()->join('jenis_dokumen_produk', 'jenis_dokumen_produk.jenis_dokumen_produk_id', 'dokumen_produk.jenis_dokumen_produk_id')->where('jenis_dokumen_produk.nama_jenis', 'Gambar')->get() as $dp)
                                <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                                    <img class="d-block w-100" src="{{ asset('storage/produk/' . $dp->nama_file) }}" height="350" alt="{{ $dp->nama_dokumen }}">
                                </div>
                                @endforeach
                                @if($lelang->dokumen_produk()->join('jenis_dokumen_produk', 'jenis_dokumen_produk.jenis_dokumen_produk_id', 'dokumen_produk.jenis_dokumen_produk_id')->where('jenis_dokumen_produk.nama_jenis', 'Gambar')->count() > 1)
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
                        @else
                        <p>Tidak Ada Gambar</p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-8">
                        <div class="section-title @if($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai') mt-8 @endif">Lelang</div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <th>Paket Lelang</th>
                                        <td>{{ $lelang->nomor_lelang }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Lelang</th>
                                        <td>{{ $lelang->jenis_inisiasi()->first()->nama_inisiasi }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hari Lelang</th>
                                        <td>{{ is_null($lelang->jenis_platform_lelang()->first()) ? 'Belum Ada' : ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? $lelang->lelang_sesi_online()->first()->tanggal . ' ' . $lelang->lelang_sesi_online()->first()->master_sesi_online()->first()->jam_mulai . ' ' . $lelang->lelang_sesi_online()->first()->master_sesi_online()->first()->jam_berakhir : ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline ? $lelang->event_lelang()->first()->tanggal_lelang . ' ' . $lelang->event_lelang()->first()->jam_mulai . '-' . $lelang->event_lelang()->first()->jam_selesai : $lelang->event_lelang()->first()->tanggal_lelang . ' ' . $lelang->event_lelang()->first()->jam_mulai . '-' . $lelang->event_lelang()->first()->jam_selesai)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Penjual</th>
                                        <td>{{ !is_null($lelang->kontrak()->first()->informasi_akun()->first()->member()->first()) ? $lelang->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama : $lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="section-title mt-2">Spesifikasi</div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <th>Kode Produk</th>
                                        <td>{{ $lelang->kontrak()->first()->kontrak_kode }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Perdagangan</th>
                                        <td>{{ $lelang->kontrak()->first()->jenis_perdagangan()->first()->nama_perdagangan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Komoditas</th>
                                        <td>{{$lelang->kontrak()->first()->komoditas()->first()->nama_komoditas}}</td>
                                    </tr>
                                    <tr>
                                        <th>Asal komoditas</th>
                                        <td>{{ $lelang->asal_komoditas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kuantitas</th>
                                        <td>{{ number_format($lelang->kuantitas, 0, ".", ",") . ' ' . $lelang->kontrak()->first()->komoditas()->first()->satuan_ukuran }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kemasan</th>
                                        <td>{{ $lelang->kemasan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Judul</th>
                                        <td>{{ $lelang->judul }}</td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>{{ $lelang->spesifikasi_produk }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="section-title mt-2">Penyelesaian</div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <th>Lokasi Serah</th>
                                        <td>{{ $lelang->lokasi_penyerahan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="section-title mt-2">Ketentuan Lelang</div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <th>Penawaran Mulai</th>
                                        <td>{{ 'Rp. ' . number_format($lelang->harga_awal, 2, ".", ",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kelipatan Penawaran</th>
                                        <td>{{ 'Rp. ' . number_format($lelang->kelipatan_penawaran, 2, ".", ",") }}</td>
                                    </tr>
                                    @if(!is_null($lelang->harga_beli_sekarang))
                                    <tr>
                                        <th>Harga Beli Sekarang</th>
                                        <td>{{ 'Rp. ' . number_format($lelang->harga_beli_sekarang, 2, ".", ",") }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="section-title mt-2">Dokumen Lainnya</div>
                        <div id="accordion">
                            @foreach($jenisDokumen as $jd)
                            <div class="card">
                                <div class="card-header" id="heading-{{ $loop->iteration }}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link {{ $loop->iteration == 1 ? 'collapsed' : '' }}" data-toggle="collapse" data-target="#collapse-{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse-{{ $loop->iteration }}">
                                            {{ $jd->nama_jenis }}
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse-{{ $loop->iteration }}" class="collapse {{ $loop->iteration == 1 ? 'show' : '' }}" aria-labelledby="heading-{{ $loop->iteration }}" data-parent="#accordion">
                                    <div class="card-body">
                                        @if($lelang->dokumen_produk()->where('jenis_dokumen_produk_id', $jd->jenis_dokumen_produk_id)->count() > 0)
                                        <div class="row">
                                        @foreach($lelang->dokumen_produk()->where('jenis_dokumen_produk_id', $jd->jenis_dokumen_produk_id)->get() as $dp)
                                            <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                                                <a href="{{ asset('storage/produk/' . $dp->nama_file) }}" target="_blank" class="btn btn-primary">{{ $jd->nama_jenis }} #{{ $loop->iteration }}</a>
                                            </div>
                                        @endforeach
                                        </div>
                                        @else
                                        <p>Tidak Ada Dokumen {{ $jd->nama_jenis }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Penawaran</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-12">Penawaran Mulai dari</div>
                                            <div class="col-12"><h5>Rp. {{ number_format($lelang->harga_awal, 0, ".", ",") }}</h5></div>
                                        </div>
                                    </li>
                                    @if($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Lelang' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Verifikasi Transaksi' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Verifikasi Transaksi Ditolak')
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-12">Penawaran Terbaik</div>
                                            @if(is_null($lelang->jenis_platform_lelang()->first()))
                                            <div class="badge badge-danger">Belum Diatur</div>
                                            @elseif($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline)
                                            <div class="col-12"><h5>Rp. {{ number_format(is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? 0 : $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan, 0, ".", ",") }}</h5></div>
                                            @elseif($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline)
                                            <div class="col-12"><h5>Rp. {{ number_format(($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan), 0, ".", ",") }}</h5></div>
                                            @else
                                            <div class="col-12"><h5>Rp. {{ number_format(($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan), 0, ".", ",") }}</h5></div>
                                            @endif
                                        </div>
                                    </li>
                                    @elseif($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Aktif')
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-12">Kelipatan Penawaran</div>
                                            <div class="col-12"><h5>Rp. {{ number_format($lelang->kelipatan_penawaran, 0, ".", ",") }}</h5></div>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="card-footer">
                                @if($lelang->status_lelang_pivot()->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')->where('status_lelang.nama_status', 'Selesai')->count() > 0)
                                    <a href="{{ route('welcome.event_offline_lelang_sesi', [$event->event_lelang_id, $lelang->lelang_id]) }}" class="btn btn-danger btn-block"><i class="fas fa-times"></i> Ditutup</a>

                                    @elseif($lelang->status_lelang_pivot()->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')->where('status_lelang.nama_status', 'Aktif')->count() > 0)

                                        @if(is_null($event->daftar_peserta_lelang_aktif()->where('lelang_id', $lelang->lelang_id)->first()))
                                        <a href="{{ route('welcome.event_offline_lelang_sesi', [$event->event_lelang_id, $lelang->lelang_id]) }}" class="btn btn-primary btn-block"><i class="fas fa-clock"></i> Menunggu Sesi Lelang</a>
                                        @else
                                            @if($event->daftar_peserta_lelang_aktif()->where('lelang_id', $lelang->lelang_id)->first()->aktif)
                                            <a href="{{ route('welcome.event_offline_lelang_sesi', [$event->event_lelang_id, $lelang->lelang_id]) }}" class="btn btn-primary btn-block"><i class="fas fa-clock"></i> Masuk</a>
                                            @else
                                            <a href="{{ route('welcome.event_offline_lelang_sesi', [$event->event_lelang_id, $lelang->lelang_id]) }}" class="btn btn-danger btn-block"><i class="fas fa-times"></i> Ditutup</a>
                                            @endif
                                        @endif
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
