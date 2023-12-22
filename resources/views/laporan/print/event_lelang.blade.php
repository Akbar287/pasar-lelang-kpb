<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Laporan Event Lelang</title>
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
        .body {
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
            font-size: 12px;
        }
        h5 {
            text-align: center;
            padding: 10px 0 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
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
        <hr>
        <div class="body">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="title" style="font-size: 20px;">Laporan Event Lelang</p>
                </div>
            </div>
            <table class="table" style="width: 100%;margin: 1rem;">
                <tr style="width: 100%">
                    <td style="font-size: 12px; width: 20%">Event Kode</td>
                    <td style="font-size: 12px; width: 30%">: {{ $data->event_kode }}</td>

                    <td style="font-size: 12px; width: 30%">Jam Mulai</td>
                    <td style="font-size: 12px; width: 20%">:{{ $data->jam_mulai }}</td>
                </tr>
                <tr style="width: 100%">
                    <td style="font-size: 12px; width: 20%">Nama Lelang</td>
                    <td style="font-size: 12px; width: 28%">: {{ $data->nama_lelang }}</td>

                    <td style="font-size: 12px; width: 30%">Jam Selesai</td>
                    <td style="font-size: 12px; width: 22%">:{{ $data->jam_selesai }}</td>
                </tr>
                <tr style="width: 100%">
                    <td style="font-size: 12px; width: 20%">Tanggal</td>
                    <td style="font-size: 12px; width: 28%">: {{ $data->tanggal_lelang }}</td>

                    <td style="font-size: 12px; width: 30%">Total Peserta</td>
                    <td style="font-size: 12px; width: 22%">:{{ $data->daftar_peserta_lelang()->count() }}</td>
                </tr>
                <tr style="width: 100%">
                    <td style="font-size: 12px; width: 20%">Lokasi</td>
                    <td style="font-size: 12px; width: 28%">: {{ $data->lokasi ?? "-" }}</td>

                    <td style="font-size: 12px; width: 30%">Total Produk Lelang</td>
                    <td style="font-size: 12px; width: 22%">:{{ $data->lelang()->count() }}</td>
                </tr>
                <tr style="width: 100%">
                    <td style="font-size: 12px; width: 20%">Ketua Lelang</td>
                    <td style="font-size: 12px; width: 28%">: {{ $data->ketua_lelang }}</td>

                    <td style="font-size: 12px; width: 30%">Status</td>
                    <td style="font-size: 12px; width: 22%">: {{ $data->is_online ? 'Hybrid' : 'Offline' }}</td>
                </tr>
            </table>
            <div class="row">
                <div class="col-12">
                    <p class="title">Daftar Peserta Lelang</p>
                    <table border="1" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nomor Peserta</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data->daftar_peserta_lelang()->count() == 0)
                            <tr><td colspan="5"><p style="text-align: center;font-size: 12px;">Tidak Ada Penerimaan Jaminan</p></td></tr>
                            @else
                            @foreach($data->daftar_peserta_lelang()->get() as $dpl)
                            <tr>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ $dpl->kode_peserta_lelang }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ !is_null($dpl->informasi_akun()->first()->member()->first()) ? $dpl->informasi_akun()->first()->member()->first()->ktp()->first()->nama : $dpl->informasi_akun()->first()->lembaga()->first()->nama_lembaga }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p class="title">Daftar Produk Lelang</p>
                    <table border="1" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nomor Lelang</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Komoditas</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Judul</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Harga Awal</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Kelipatan</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Harga Pemenang</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data->lelang()->count() == 0)
                            <tr><td colspan="5"><p style="text-align: center;font-size: 12px;">Tidak Ada Produk Lelang</p></td></tr>
                            @else
                            @php  $total = 0; @endphp
                            @foreach($data->lelang()->get() as $lelang)
                            <tr>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ $lelang->nomor_lelang }}</td>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ $lelang->kontrak()->first()->komoditas()->first()->nama_komoditas }}</td>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ $lelang->judul }}</td>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ 'Rp. '. number_format($lelang->harga_awal, 0, ".", ",") }}</td>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ 'Rp. '. number_format($lelang->kelipatan_penawaran, 0, ".", ",") }}</td>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ 'Rp. '. number_format(is_null($lelang->approval_lelang()->first()) ? 0 : $lelang->approval_lelang()->first()->harga_pemenang, 0, ".", ",") }}</td>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ !is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? 'Terjual' : "Tidak Terjual" }}</td>
                            </tr>
                            @php  $total = $total + (is_null($lelang->approval_lelang()->first()) ? 0 : $lelang->approval_lelang()->first()->harga_pemenang)  @endphp
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mb-4 mt-4">
                <div class="col-12">
                    <p class="title">Total Transaksi: <span>Rp.  @php echo number_format($total,0 , ",", ".") @endphp </span></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 10px;font-style:italic;">Dicetak Pada: {{ now() }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
