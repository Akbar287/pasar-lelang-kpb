<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Laporan Lelang</title>
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
                    <p class="title" style="font-size: 20px;">Laporan Lelang Online</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @foreach($event as $data)
                    <table class="table" style="width: 100%;margin: 1rem;">
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 20%">Tanggal</td>
                            <td style="font-size: 12px; width: 30%">: {{ $tgl }}</td>

                            <td style="font-size: 12px; width: 30%">Jam Mulai</td>
                            <td style="font-size: 12px; width: 20%">:{{ $data['jam_mulai'] }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 20%">Sesi</td>
                            <td style="font-size: 12px; width: 28%">: {{ $data['sesi'] }}</td>

                            <td style="font-size: 12px; width: 30%">Jam Selesai</td>
                            <td style="font-size: 12px; width: 22%">:{{ $data['jam_berakhir'] }}</td>
                        </tr>
                    </table>

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
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data['data']) == 0)
                                    <tr><td colspan="6"><p style="text-align: center;font-size: 12px;">Tidak Ada Produk Lelang</p></td></tr>
                                    @else
                                    @foreach($data['data'] as $lelang)
                                    <tr>
                                        <td class="name" style="padding: 5px; font-size: 10px;">{{ $lelang['nomor_lelang'] }}</td>
                                        <td class="name" style="padding: 5px; font-size: 10px;">{{ $lelang['nama_komoditas'] }}</td>
                                        <td class="name" style="padding: 5px; font-size: 10px;">{{ $lelang['judul'] }}</td>
                                        <td class="name" style="padding: 5px; font-size: 10px;">{{ 'Rp. '. number_format($lelang['harga_awal'], 0, ".", ",") }}</td>
                                        <td class="name" style="padding: 5px; font-size: 10px;">{{ 'Rp. '. number_format($lelang['kelipatan_penawaran'], 0, ".", ",") }}</td>
                                        <td class="name" style="padding: 5px; font-size: 10px;">{{ is_null($lelang['harga_pemenang']) ? '-' : $lelang['harga_pemenang'] }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <p style="font-size: 20px;margin-top: 20px;">Peserta Lelang</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="title">Penjual</p>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <th><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">No</p></th>
                                        <th><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nama Penjual</p></th>
                                        <th><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">Komoditi</p></th>
                                    </thead>
                                    <tbody>

                                        @foreach(App\Models\MasterSesiLelang::distinct('kontrak.informasi_akun_id')->where('sesi', $data['sesi'])->join('lelang_sesi_online', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')->join('lelang', 'lelang.lelang_id', 'lelang_sesi_online.lelang_id')->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')->leftJoin('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'kontrak.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('ktp', 'ktp.member_id', 'member.member_id')->get()->toArray() as $p)
                                        <tr>
                                            <td><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">{{ $loop->iteration }}</p></td>
                                            <td><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">{{ $p['nama'] }}</p></td>
                                            <td><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">{{ $p['nama_komoditas'] }}</p></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <p style="text-align: center;font-size: 20px;margin-top:20px;">Pembeli</p>
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <th><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">No</p></th>
                                    <th><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nama Pembeli</p></th>
                                    <th><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">Kode Peserta Sesi</p></th>
                                </thead>
                                <tbody>
                                    @if(App\Models\MasterSesiLelang::where('sesi', $data['sesi'])->first()->peserta_lelang()->where('tanggal', $tgl)->count() > 0)
                                    @foreach(App\Models\MasterSesiLelang::where('sesi', $data['sesi'])->first()->peserta_lelang()->where('tanggal', $tgl)->get() as $dpl)
                                    <tr>
                                        <td><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">{{ $loop->iteration }}</p></td>
                                        <td><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">{{ $dpl->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}</p></td>
                                        <td><p style="padding-left: 2px;font-weight: normal; font-size: 12px;">{{ $dpl->kode_peserta_lelang }}</p></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td colspan="3"><p style="text-align: center;font-size: 12px;">Tidak Ada Produk Lelang</p></td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @endforeach
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
