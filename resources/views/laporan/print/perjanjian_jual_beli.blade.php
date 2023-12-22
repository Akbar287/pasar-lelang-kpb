<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Perjanjian Jual Beli</title>
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
                    <p class="title">Perjanjian Jual Beli<br />Komoditi Agro di e-Pasar Lelang<br />No: {{ !is_null($lelang->approval_lelang()->first()) ? (!is_null($lelang->approval_lelang()->first()->nomor_surat()->first()) ? $lelang->approval_lelang()->first()->nomor_surat()->first()->no_surat : '-') : '-' }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text">Pada hari ini {{ Carbon\Carbon::now()->isoFormat('dddd') }} tanggal {{ Carbon\Carbon::now()->format('d F Y') }} di {{ is_null($event) ? 'Online' : $event->lokasi }}, telah dibuat dan ditandatangani Perjanjian Jual Beli Komoditi Agro di e-Pasar Lelang oleh pihak – pihak dibawah ini:</p>
                    <table border="0">
                        <tbody>
                            <tr style="padding: 0;">
                                <td style="line-height: normal;width: 30%;"><p class="text">Kode Anggota</p></td>
                                @if($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline)
                                <td style="width: 70%;line-height: normal;"><p class="text">: {{ !is_null($lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('informasi_akun_id', $penjual->informasi_akun()->first()->informasi_akun_id)->first() ? $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('informasi_akun_id', $penjual->informasi_akun()->first()->informasi_akun_id)->first()->kode_peserta_lelang : '-') }}</p></td>
                                @endif
                                @if($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline)
                                <td style="width: 70%;line-height: normal;"><p class="text">: {{ !is_null($event->daftar_peserta_lelang()->where('informasi_akun_id', $penjual->informasi_akun()->first()->informasi_akun_id)->first()) ? $event->daftar_peserta_lelang()->where('informasi_akun_id', $penjual->informasi_akun()->first()->informasi_akun_id)->first()->kode_peserta_lelang : '-' }}</p></td>
                                @endif
                                @if(!$lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline)
                                <td style="width: 70%;line-height: normal;"><p class="text">: {{ !is_null($event->daftar_peserta_lelang()->where('informasi_akun_id', $penjual->informasi_akun()->first()->informasi_akun_id)->first()) ? $event->daftar_peserta_lelang()->where('informasi_akun_id', $penjual->informasi_akun()->first()->informasi_akun_id)->first()->kode_peserta_lelang : '-' }}</p></td>
                                @endif
                            </tr>
                            <tr style="padding: 0;">
                                <td style="line-height: normal;width: 30%;"><p class="text">Nama</p></td>
                                <td style="width: 70%;line-height: normal;"><p class="text">: {{ $penjual->ktp()->first()->nama }}</p></td>
                            </tr>
                            <tr style="padding: 0;">
                                <td style="line-height: normal;width: 30%;"><p class="text">Alamat</p></td>
                                <td style="width: 70%;line-height: normal;"><p class="text">: {{ !is_null($penjual->informasi_akun()->first()->area_member()->first()) ? $penjual->informasi_akun()->first()->area_member()->first()->alamat : "-" }}</p></td>
                            </tr>
                            <tr style="padding: 0;">
                                <td style="line-height: normal;width: 30%;"><p class="text">No. Telepon</p></td>
                                <td style="width: 70%;line-height: normal;"><p class="text">: {{ $penjual->informasi_akun()->first()->no_hp }}</p></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="text">Dalam rangka hal ini bertindak untuk dan atas nama {{$penjual->ktp()->first()->nama }} sebagai Penjual komoditi pada e-Pasar Lelang yang diselenggarakan di {{ is_null($event) ? 'Online' : $event->lokasi }} selanjutnya disebut PIHAK PERTAMA.</p>
                    <table border="0">
                        <tbody>
                            <tr style="padding: 0;">
                                <td style="line-height: normal;width: 30%;"><p class="text">Kode Anggota</p></td>
                                <td style="width: 70%;line-height: normal;"><p class="text">: {{ $pembeli['kode'] }} </p></td>
                            </tr>
                            <tr style="padding: 0;">
                                <td style="line-height: normal;width: 30%;"><p class="text">Nama</p></td>
                                <td style="width: 70%;line-height: normal;"><p class="text">: {{ $pembeli['nama'] }}</p></td>
                            </tr>
                            <tr style="padding: 0;">
                                <td style="line-height: normal;width: 30%;"><p class="text">Alamat</p></td>
                                <td style="width: 70%;line-height: normal;"><p class="text">: {{ $pembeli['alamat'] }}</p></td>
                            </tr>
                            <tr style="padding: 0;">
                                <td style="line-height: normal;width: 30%;"><p class="text">No. Telepon</p></td>
                                <td style="width: 70%;line-height: normal;"><p class="text">: {{ $pembeli['no_hp'] }}</p></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="text">Dalam hal ini bertindak untuk dan atas nama {{ $pembeli['nama'] }} sebagai Pembeli komoditi pada Pasar Lelang Forward yang di selenggarakan di {{ is_null($event) ? 'Online' : $event->lokasi }} selanjutnya disebut PIHAK KEDUA</p>
                    <p class="text">Kedua belah pihak sepakat untuk mengadakan perjanjian jual beli melalui Pasar Lelang Forward dengan ketentuan sebagai berikut :</p>

                    <div class="row">
                        <div class="col-12">
                            <p class="text" style="text-align: center;line-height: normal;">Pasal 1</p>
                            <table border="0" style="padding-bottom: 20px;">
                                <tbody>
                                    <tr>
                                        <td style="font-size: 12px;line-height: normal;width: 30%;">Nama Komoditi: </td>
                                        <td style="font-size: 12px;width: 70%;line-height: normal;">: {{ $lelang->kontrak()->first()->komoditas()->first()->nama_komoditas }} </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;line-height: normal;width: 30%;">Jenis: </td>
                                        <td style="font-size: 12px;width: 70%;line-height: normal;">: {{ $lelang->kontrak()->first()->jenis_perdagangan()->first()->nama_perdagangan }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;line-height: normal;width: 30%;">Kualitas: </td>
                                        <td style="font-size: 12px;width: 70%;line-height: normal;">: {{ $lelang->kontrak()->first()->mutu()->first()->nama_mutu }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;line-height: normal;width: 30%;">Asal Komoditi: </td>
                                        <td style="font-size: 12px;width: 70%;line-height: normal;">: {{ $lelang->asal_komoditas }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;line-height: normal;width: 30%;">Harga Awal: </td>
                                        <td style="font-size: 12px;width: 70%;line-height: normal;">: {{ 'Rp. '. number_format($lelang->harga_awal, 0, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;line-height: normal;width: 30%;">Kelipatan Penawaran: </td>
                                        <td style="font-size: 12px;width: 70%;line-height: normal;">: {{ 'Rp. '. number_format($lelang->kelipatan_penawaran, 0, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;line-height: normal;width: 30%;">Kuantitas: </td>
                                        <td style="font-size: 12px;width: 70%;line-height: normal;">: {{ $lelang->kuantitas . ' (' . $lelang->kontrak()->first()->komoditas()->first()->satuan_ukuran . ')' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;line-height: normal;width: 30%;">Kemasan: </td>
                                        <td style="font-size: 12px;width: 70%;line-height: normal;">: {{ $lelang->kemasan }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;line-height: normal;width: 30%;">Tempat Penyerahan: </td>
                                        <td style="font-size: 12px;width: 70%;line-height: normal;">: {{ $lelang->lokasi_penyerahan }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;line-height: normal;width: 30%;">Waktu Penyerahan: </td>
                                        <td style="font-size: 12px;width: 70%;line-height: normal;">: </td>
                                    </tr>
                                    @if(!is_null($lelang->approval_lelang()->first()))
                                            @if(!is_null($lelang->approval_lelang()->first()->nomor_surat()->first()))
                                                @if($lelang->approval_lelang()->first()->nomor_surat()->first()->waktu_penyerahan()->count() > 0)
                                                @foreach($lelang->approval_lelang()->first()->nomor_surat()->first()->waktu_penyerahan()->get() as $wp)
                                                <tr>
                                                    <td style="font-size: 12px;line-height: normal;width: 30%;"></td>
                                                    <td style="font-size: 12px;width: 70%;line-height: normal;">{{ $loop->iteration }}. Tanggal {{ App\Http\Helper\Helper::reformatDate($wp->tanggal) }}    Volume {{ $wp->volume }}</td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td style="font-size: 12px;line-height: normal;width: 30%;"></td>
                                                    <td style="font-size: 12px;width: 70%;line-height: normal;">1. Tanggal ....    Volume .....</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;line-height: normal;width: 30%;"></td>
                                                    <td style="font-size: 12px;width: 70%;line-height: normal;">2. Tanggal ....    Volume .....</td>
                                                </tr>
                                                @endif
                                            @else
                                            <tr>
                                                <td style="font-size: 12px;line-height: normal;width: 30%;"></td>
                                                <td style="font-size: 12px;width: 70%;line-height: normal;">1. Tanggal ....    Volume .....</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 12px;line-height: normal;width: 30%;"></td>
                                                <td style="font-size: 12px;width: 70%;line-height: normal;">2. Tanggal ....    Volume .....</td>
                                            </tr>
                                            @endif
                                        @else
                                        <tr>
                                            <td style="font-size: 12px;line-height: normal;width: 30%;"></td>
                                            <td style="font-size: 12px;width: 70%;line-height: normal;">1. Tanggal ....    Volume .....</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px;line-height: normal;width: 30%;"></td>
                                            <td style="font-size: 12px;width: 70%;line-height: normal;">2. Tanggal ....    Volume .....</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @foreach($pasal as $p)
                            <p class="text" style="text-align: center;line-height: normal;">{{$p->key}}</p>
                            <p class="text">{{$p->value}}</p>
                            @endforeach
                        </div>
                    </div>

                    <p class="text">Surat Perjanjian ini dibuat dan ditandatangani oleh para pihak pada hari, tanggal, bulan dan tahun tersebut diatas, dibuat dalam rangkap 5 (lima), masing – masing bermateri secukupnya dan, mempunyai kekuatan hukum yang sama</p>
                    <table border="0">
                        <tr>
                            <td>
                                <p class="title" style="margin-bottom:80px;font-size: 14px;">Pihak Pertama</p>
                                <p style="font-size: 14px;text-align:center;text-transform: uppercase;">({{ ucwords($penjual->ktp()->first()->nama) }})</p>
                            </td>
                            <td>
                                <p class="title" style="margin-bottom:80px;font-size: 14px;">Pihak Kedua</p>
                                <p style="font-size: 14px;text-align:center;text-transform: uppercase;">({{ ucwords($pembeli['nama']) }})</p>
                            </td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-12" style="text-align: center">
                            <p style="line-height: normal;">Mengetahui</p>
                            <p class="title" style="font-size: 14px;line-height: normal;">Penyelenggara Pasar Lelang</p>
                            <p style="font-size: 14px;margin-bottom: 80px;">Ketua Lelang</p>
                            @if(is_null($event))
                            <p style="font-size: 14px;text-align:center;text-transform: uppercase;">(...................................)</p>
                            @else
                            <p style="font-size: 14px;text-align:center;text-transform: uppercase;">({{ ucwords($event->ketua_lelang) }})</p>
                            @endif
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
