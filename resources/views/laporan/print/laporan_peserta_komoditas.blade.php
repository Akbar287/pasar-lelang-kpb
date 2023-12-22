<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Laporan Peserta Komoditi</title>
    <style>
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            width: 100%;
        }
        .container {
            width: 100%;
        }
        .header {
          text-align: center;
          line-height: 25px;
          text-transform: uppercase;
        }
        .header span {
            font-size: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .body .title {
            text-transform: uppercase;
            text-decoration: underline;
            text-align:center;
        }
        .body .text-muted {
            text-transform: uppercase;
            text-align:center;
            font-weight: bold;
        }
        .footer p {
            font-weight: bold;
            text-align:center;
        }
        td.name {
            font-size: 12px;
            font-weight:normal;
        }
        p.info {
            font-size: 10px;
        }
        h5 {
            text-align: center;
            padding: 10px 0 0 10px;
        }
        .text {
            font-size: 12px;
            text-indent: 30px;
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- <div class="header">
            <table border="0"  style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 20%;"><img src="{{ $logo }}" width="50" alt="logo"></td>
                        <td style="width: 80%;text-align:center;">
                            <p>Sekretariat e-KPB</b></span><br>Jl. Way Rarem No. 7 Teluk Betung, Engal<br>Telp. (021) 12345, Fax (021) 1234</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr> --}}
        <div class="body">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="title">Laporan Peserta Komoditi<br />Komoditi Agro di e-Pasar Lelang</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text">Pada tanggal {{ Carbon\Carbon::now()->format('d F Y') }} di {{ is_null($event) ? 'Online' : $event->lokasi }}, akan diadakan event lelang yang informasi nya terlampir dibawah ini: </p>
                    <table class="table" style="width: 100%;margin: 1rem;">
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 20%">Event Kode</td>
                            <td style="font-size: 12px; width: 30%">: {{ $event->event_kode }}</td>

                            <td style="font-size: 12px; width: 30%">Jam Mulai</td>
                            <td style="font-size: 12px; width: 20%">:{{ $event->jam_mulai }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 20%">Nama Lelang</td>
                            <td style="font-size: 12px; width: 28%">: {{ $event->nama_lelang }}</td>

                            <td style="font-size: 12px; width: 30%">Jam Selesai</td>
                            <td style="font-size: 12px; width: 22%">:{{ $event->jam_selesai }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 20%">Tanggal</td>
                            <td style="font-size: 12px; width: 28%">: {{ $event->tanggal_lelang }}</td>

                            <td style="font-size: 12px; width: 30%">Total Peserta</td>
                            <td style="font-size: 12px; width: 22%">:{{ $event->daftar_peserta_lelang()->count() }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 20%">Lokasi</td>
                            <td style="font-size: 12px; width: 28%">: {{ $event->lokasi ?? "-" }}</td>

                            <td style="font-size: 12px; width: 30%">Total Produk Lelang</td>
                            <td style="font-size: 12px; width: 22%">:{{ $event->lelang()->count() }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 20%">Ketua Lelang</td>
                            <td style="font-size: 12px; width: 28%">: {{ $event->ketua_lelang }}</td>

                            <td style="font-size: 12px; width: 30%">Status</td>
                            <td style="font-size: 12px; width: 22%">: {{ $event->is_online ? 'Hybrid' : 'Offline' }}</td>
                        </tr>
                    </table>
                    <p class="text">selain itu, telah terdaftar penjual dan pembeli yang dapat dilihat dibawah ini:</p>

                    <p class="title">Penjual</p>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama Penjual</th>
                                <th>Komoditi</th>
                            </thead>
                            <tbody>
                                @foreach($penjual as $p)
                                <tr>
                                    <td rowspan="{{ count($p['komoditas']) }}">{{ $loop->iteration }}</td>
                                    <td rowspan="{{ count($p['komoditas']) }}">{{ $p['nama'] }}</td>
                                    @if(count($p['komoditas']) > 0) <td>{{ $p['komoditas']['0'] }}</td> @endif
                                </tr>
                                @if(count($p['komoditas']) > 1)
                                @for($i = 1; $i < count($p['komoditas']); $i++)
                                <tr>
                                    <td>{{ $p['komoditas'][$i] }}</td>
                                </tr>
                                @endfor
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <p class="title">Pembeli</p>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Nama Pembeli</th>
                            <th>Kode Peserta Sesi</th>
                        </thead>
                        <tbody>
                            @foreach($event->daftar_peserta_lelang()->get() as $dpl)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dpl->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}</td>
                                <td>{{ $dpl->kode_peserta_lelang }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-12" style="text-align: center">
                            <p style="line-height: normal;">Mengetahui</p>
                            <p class="title" style="font-size: 14px;line-height: normal;">Penyelenggara Pasar Lelang</p>
                            <p style="font-size: 14px;margin-bottom: 80px;">Ketua Lelang</p>
                            <p style="font-size: 14px;text-align:center;text-transform: uppercase;">({{ ucwords($event->ketua_lelang) }})</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p class="text">Dicetak Pada: {{ now() }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
