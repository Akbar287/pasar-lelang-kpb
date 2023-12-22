<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Laporan Jaminan</title>
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
                    <p class="title" style="font-size: 20px;">Laporan Jaminan</p>
                </div>
            </div>
            <p class="text-muted" style="font-size: 16px;">{{ $date['awal'] . ' s/d ' . $date['akhir'] }}</p>
            @if(!is_null($member))
            <table class="table" style="width: 100%;margin: 1rem;">
                <tr style="width: 100%">
                    <td style="font-size: 12px; width: 20%">Nomor KTP</td>
                    <td style="font-size: 12px; width: 30%">: {{ $member->ktp()->first()->nik }}</td>

                    <td style="font-size: 12px; width: 30%">Saldo Digunakan</td>
                    <td style="font-size: 12px; width: 20%">: Rp. {{ number_format(!is_null($member->informasi_akun()->first()->jaminan()->first()) ? $member->informasi_akun()->first()->jaminan()->first()->saldo_teralokasi : 0, 0, ".", ",") }}</td>
                </tr>
                <tr style="width: 100%">
                    <td style="font-size: 12px; width: 20%">Nama</td>
                    <td style="font-size: 12px; width: 28%">: {{ $member->ktp()->first()->nama }}</td>

                    <td style="font-size: 12px; width: 30%">Saldo Tersedia</td>
                    <td style="font-size: 12px; width: 22%">: Rp. {{ number_format(!is_null($member->informasi_akun()->first()->jaminan()->first()) ? $member->informasi_akun()->first()->jaminan()->first()->saldo_tersedia : 0, 0, ".", ",") }}</td>
                </tr>
            </table>
            @endif
            <div class="row">
                <div class="col-12">
                    @if(!is_null($data['masuk']))
                    <p class="title">Penerimaan Jaminan</p>
                    <table border="1" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Tanggal</th>
                                @if(is_null($member))<th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nama</th>@endif
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Jenis</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nilai</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nilai Penyesuaian</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($data['masuk']) == 0)
                            <tr><td colspan="5"><p style="text-align: center;font-size: 12px;">Tidak Ada Penerimaan Jaminan</p></td></tr>
                            @else
                            @foreach($data['masuk'] as $masuk)
                            <tr>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ $masuk->tanggal_transaksi }}</td>
                                @if(is_null($member))<td class="name" style="padding: 5px;font-size: 10px;">{{ $masuk->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}</td>@endif
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ (!is_null($masuk->kas()->first()) ? 'Kas' : !is_null($masuk->registrasi_komoditas_jaminan()->first())) ? 'Komoditas' : 'Surat Berharga' }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ 'Rp.'. number_format($masuk->nilai_jaminan, 0, ".", ",") }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ 'Rp.'. number_format($masuk->nilai_penyesuaian, 0, ".", ",") }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ $masuk->is_aktif ? 'Verifikasi' : "Tidak Verifikasi" }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if(!is_null($data['keluar']))
                    <p class="title">Pengeluaran Jaminan</p>
                    <table border="1" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Tanggal</th>
                                @if(is_null($member))<th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nama</th>@endif
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Kode Transaksi</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Jenis</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nilai</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($data['keluar']) == 0)
                            <tr><td colspan="5"><p style="text-align: center;font-size: 12px;">Tidak Ada Pengeluaran Jaminan</p></td></tr>
                            @else
                            @foreach($data['keluar'] as $keluar)
                            <tr>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ $keluar->tanggal }}</td>
                                @if(is_null($member))<td class="name" style="padding: 5px;font-size: 10px;">{{ $masuk->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}</td>@endif
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ $keluar->kode_transaksi }}</td>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ $keluar->jenis_pengeluaran_jaminan()->first()->nama_jenis }}</td>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ 'Rp. '. number_format($keluar->jumlah, 0, ".", ",") }}</td>
                                <td class="name" style="padding: 5px; font-size: 10px;">{{ $keluar->is_aktif ? 'Verifikasi' : "Tidak Verifikasi" }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    @endif
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
