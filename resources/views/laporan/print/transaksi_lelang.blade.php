<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Laporan Transaksi Lelang</title>
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
                    <p class="title" style="font-size: 20px;">Laporan Transaksi Lelang</p>
                </div>
            </div>
            <p class="text-muted" style="font-size: 16px;">{{ $date['awal'] . ' s/d ' . $date['akhir'] }}</p>
            @if(!is_null($member))
            <table class="table" style="width: 100%;margin: 1rem;">
                <tr style="width: 100%">
                    <td style="font-size: 12px; width: 20%">Nomor KTP</td>
                    <td style="font-size: 12px; width: 30%">: {{ $member->ktp()->first()->nik }}</td>

                    <td style="font-size: 12px; width: 30%">Role</td>
                    <td style="font-size: 12px; width: 20%">: @php $temp = [] @endphp @foreach($member->role()->get() as $r) @php $temp[] = $r->nama_role @endphp @endforeach  {{join(', ', $temp)}} </td>
                </tr>
                <tr style="width: 100%">
                    <td style="font-size: 12px; width: 20%">Nama</td>
                    <td style="font-size: 12px; width: 28%">: {{ $member->ktp()->first()->nama }}</td>

                    <td style="font-size: 12px; width: 30%">Setting Collateral</td>
                    <td style="font-size: 12px; width: 22%">: @php $temp = []; @endphp @foreach($member->setting_collateral()->get() as $r) @php $temp[] = $r->jenis_inisiasi()->first()->nama_inisiasi @endphp @endforeach  {{join(', ', $temp)}}</td>
                </tr>
            </table>
            @endif
            <div class="row">
                <div class="col-12">
                    @if(!is_null($data))
                    <table border="1" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Tanggal</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nomor Penyelesaian</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Status</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Nama</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Tagihan</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Biaya Lain</th>
                                <th style="padding-left: 2px;font-weight: normal; font-size: 12px;">Penyelesaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($data) == 0)
                            <tr><td colspan="5"><p style="text-align: center;font-size: 12px;">Tidak Ada Transaksi Lelang</p></td></tr>
                            @else
                            @foreach($data as $ev)
                            <tr>
                                <td rowspan="2" class="name" style="padding: 5px;font-size: 10px;">{{ $ev->created_at->format('d F Y') }}</td>
                                <td rowspan="2" class="name" style="padding: 5px;font-size: 10px;">{{ $ev->nomor_penyelesaian }}</td>
                                <td rowspan="2" class="name" style="padding: 5px;font-size: 10px;">{{ (is_null($ev->verified_log()->first()) ? "Belum Verifikasi" : $ev->verified_log()->first()->is_agree) ? 'Verifikasi' : "Tidak Verifikasi" }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ is_null($ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->informasi_akun()->first()->member()->first()) ? $ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ 'Rp.'. number_format(is_null($ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()) ? 0 : $ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->tagihan, 0, ".", ",") }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ 'Rp.'. number_format(is_null($ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()) ? 0 : $ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain, 0, ".", ",") }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ 'Rp.'. number_format(is_null($ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()) ? : $ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->penyelesaian, 0, ".", ",") }}</td>
                            </tr>
                            <tr>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ is_null($ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->informasi_akun()->first()->member()->first()) ? $ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ 'Rp.'. number_format(is_null($ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()) ? 0 : $ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->tagihan, 0, ".", ",") }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ 'Rp.'. number_format(is_null($ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()) ? 0 : $ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->biaya_lain_lain, 0, ".", ",") }}</td>
                                <td class="name" style="padding: 5px;font-size: 10px;">{{ 'Rp.'. number_format(is_null($ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()) ? : $ev->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->penyelesaian, 0, ".", ",") }}</td>
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
