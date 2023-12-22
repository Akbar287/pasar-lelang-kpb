<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Laporan Daftar Anggota</title>
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
                    <p class="title" style="font-size: 20px;">Laporan Anggota</p>
                </div>
            </div>
            @if($chooser == 2 || $chooser == '2' || $chooser == 4 || $chooser == '4')
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 12px;">Informasi List</p>
                    <table class="table" style="width: 100%;margin: 1rem;">
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Jenis Keanggotaan</td>
                            <td style="font-size: 12px; width: 50%">: {{ $chooser == 2 || $chooser == '2' ? 'Perorangan' : 'Lembaga' }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Banyak Data</td>
                            <td style="font-size: 12px; width: 50%">: {{ is_string($status) ? $statusCount : $status->count() }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Status Dipilih</td>
                            <td style="font-size: 12px; width: 50%">: {{ $filterStatus }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
            @if($chooser == 2 || $chooser == '2')
                @if(is_string($status))
                <table class="table" style="width: 100%;">
                    <thead>
                        <th style="font-size: 12px;">Status</th>
                        <th style="font-size: 12px;">Banyak Data</th>
                    </thead>
                    <tbody>
                        @foreach($statusList as $am)
                        <tr style="width: 100%;">
                            <td style="font-size: 12px;">{{ $am->nama_status }}</td>
                            <td style="font-size: 12px;">{{ $am->member()->count() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="row">
                    <div class="col-12">
                        <p style="font-size: 12px;">List Anggota {{ $filterStatus }}</p>
                        @if($status->count() > 0)
                        <table class="table" style="width: 100%;">
                            <thead>
                                <th style="font-size: 12px;">No</th>
                                <th style="font-size: 12px;">NIK</th>
                                <th style="font-size: 12px;">Nama</th>
                                <th style="font-size: 12px;">Username</th>
                            </thead>
                            <tbody>
                                @foreach($status as $am)
                                <tr style="width: 100%;">
                                    <td style="font-size: 12px;">{{ $loop->iteration }}</td>
                                    <td style="font-size: 12px;">{{ $am->ktp()->first()->nik }}</td>
                                    <td style="font-size: 12px;">{{ $am->ktp()->first()->nama }}</td>
                                    <td style="font-size: 12px;">{{ $am->informasi_akun()->first()->userlogin()->first()->username }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>Tidak Ada Anggota</p>
                        @endif
                    </div>
                </div>
                @endif
            @endif
            @if($chooser == 4 || $chooser == '4')
                @if(is_string($status))
                <table class="table" style="width: 100%;">
                    <thead>
                        <th style="font-size: 12px;">Status</th>
                        <th style="font-size: 12px;">Banyak Data</th>
                    </thead>
                    <tbody>
                        @foreach($statusList as $am)
                        <tr style="width: 100%;">
                            <td style="font-size: 12px;">{{ $am->nama_status }}</td>
                            <td style="font-size: 12px;">{{ $am->lembaga()->count() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="row">
                    <div class="col-12">
                        <p style="font-size: 12px;">List Lembaga {{ $filterStatus }}</p>
                        @if($status->count() > 0)
                        <table class="table" style="width: 100%;">
                            <thead>
                                <th style="font-size: 12px;">No</th>
                                <th style="font-size: 12px;">NPWP</th>
                                <th style="font-size: 12px;">Nama Lembaga</th>
                                <th style="font-size: 12px;">Username</th>
                            </thead>
                            <tbody>
                                @foreach($status as $am)
                                <tr style="width: 100%;">
                                    <td style="font-size: 12px;">{{ $loop->iteration }}</td>
                                    <td style="font-size: 12px;">{{ $am->npwp()->first()->npwp }}</td>
                                    <td style="font-size: 12px;">{{ $am->nama_lembaga }}</td>
                                    <td style="font-size: 12px;">{{ $am->informasi_akun()->first()->userlogin()->first()->username }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>Tidak Ada Anggota</p>
                        @endif
                    </div>
                </div>
                @endif
            @endif
            @if(!is_null($member))
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 12px;">Informasi Pribadi</p>
                    <table class="table" style="width: 100%;margin: 1rem;">
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Status Anggota</td>
                            <td style="font-size: 12px; width: 50%">: {{ $member->status_member()->first()->nama_status }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Username</td>
                            <td style="font-size: 12px; width: 50%">: {{ $member->informasi_akun()->first()->userlogin()->first()->username }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Nama</td>
                            <td style="font-size: 12px; width: 50%">: {{ $member->ktp()->first()->nama }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">NIK</td>
                            <td style="font-size: 12px; width: 50%">: {{ $member->ktp()->first()->nik }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Jenis Kelamin</td>
                            <td style="font-size: 12px; width: 50%">: {{ $member->ktp()->first()->jenis_kelamin }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Admin</td>
                            <td style="font-size: 12px; width: 50%">: {{ is_null($member->admin()->first()) ? "Tidak" : "Ya" }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">No. HP</td>
                            <td style="font-size: 12px; width: 50%">: {{ $member->informasi_akun()->first()->no_hp }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">No. Wa</td>
                            <td style="font-size: 12px; width: 50%">: {{ $member->informasi_akun()->first()->no_wa }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">No. Fax</td>
                            <td style="font-size: 12px; width: 50%">: {{ $member->informasi_akun()->first()->no_fax }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Email</td>
                            <td style="font-size: 12px; width: 50%">: {{ $member->informasi_akun()->first()->email }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Tempat, Tanggal Lahir</td>
                            <td style="font-size: 12px; width: 50%">: {{ $member->ktp()->first()->tempat_lahir . ', ' . $member->ktp()->first()->tanggal_lahir }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Role</td>
                            <td style="font-size: 12px; width: 50%">: @foreach($member->role()->get() as $r) @php $temp[] = $r->nama_role @endphp @endforeach  {{join(', ', $temp)}} </td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Pengaturan Collateral</td>
                            <td style="font-size: 12px; width: 50%">: @php $temp = []; @endphp @foreach($member->setting_collateral()->get() as $r) @php $temp[] = $r->jenis_inisiasi()->first()->nama_inisiasi @endphp @endforeach  {{join(', ', $temp)}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 12px;">Informasi Keuangan</p>
                    <table class="table" style="width: 100%;margin: 1rem;">
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">NPWP</td>
                            <td style="font-size: 12px; width: 50%">: {{ (is_null($member->informasi_keuangan()->first()) ? "Tidak Ada Data" : is_null($member->informasi_keuangan()->first()->npwp()->first())) ? "Tidak Ada Data" : $member->informasi_keuangan()->first()->npwp()->first()->npwp }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Pekerjaan</td>
                            <td style="font-size: 12px; width: 50%">: {{ is_null($member->informasi_keuangan()->first()) ? "Tidak Ada Data" : $member->informasi_keuangan()->first()->pekerjaan }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Pendapatan Tahunan</td>
                            <td style="font-size: 12px; width: 50%">: {{ is_null($member->informasi_keuangan()->first()) ? "Tidak Ada Data" : $member->informasi_keuangan()->first()->pendapatan_tahunan }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Kekayaan Bersih</td>
                            <td style="font-size: 12px; width: 50%">: {{ is_null($member->informasi_keuangan()->first()) ? "Tidak Ada Data" : 'Rp. ' .number_format($member->informasi_keuangan()->first()->kekayaan_bersih, 0, ".", ",") }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Kekayaan Lancar</td>
                            <td style="font-size: 12px; width: 50%">: {{ is_null($member->informasi_keuangan()->first()) ? "Tidak Ada Data" : 'Rp. ' .number_format($member->informasi_keuangan()->first()->kekayaan_lancar, 0, ".", ",") }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Sumber Dana</td>
                            <td style="font-size: 12px; width: 50%">: {{ is_null($member->informasi_keuangan()->first()) ? "Tidak Ada Data" : $member->informasi_keuangan()->first()->sumber_dana }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Keterangan</td>
                            <td style="font-size: 12px; width: 50%">: {{ (is_null($member->informasi_keuangan()->first()) ? "Tidak Ada Data" : $member->informasi_keuangan()->first()->keterangan == "" )? "-" : $member->informasi_keuangan()->first()->keterangan }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 12px;">Informasi Dokumen</p>
                    @if($member->informasi_akun()->first()->dokumen_member()->count() > 0)
                    <table class="table" style="width: 100%;">
                        <thead>
                            <th style="font-size: 12px;">Jenis Dokumen</th>
                            <th style="font-size: 12px;">Nama Dokumen</th>
                            <th style="font-size: 12px;">Tanggal</th>
                        </thead>
                        <tbody>
                            @foreach($member->informasi_akun()->first()->dokumen_member()->get() as $dm)
                            <tr style="width: 100%;">
                                <td style="font-size: 12px;">{{ $dm->jenis_dokumen()->first()->nama_jenis }}</td>
                                <td style="font-size: 12px;">{{ $dm->nama_dokumen }}</td>
                                <td style="font-size: 12px;">{{ $dm->tanggal_unggah }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p style="font-size: 12px;">Tidak Ada Informasi Dokumen</p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 12px;">Informasi Rekening Bank</p>
                    @if($member->informasi_akun()->first()->rekening_bank()->count() > 0)
                    <table class="table" style="width: 100%;">
                        <thead>
                            <th style="font-size: 12px;">Nomor Rekening</th>
                            <th style="font-size: 12px;">Nama</th>
                            <th style="font-size: 12px;">Cabang</th>
                            <th style="font-size: 12px;">Mata Uang</th>
                            <th style="font-size: 12px;">Saldo</th>
                        </thead>
                        <tbody>
                            @foreach($member->informasi_akun()->first()->rekening_bank()->get() as $rb)
                            <tr style="width: 100%;">
                                <td style="font-size: 12px;">{{ $rb->nomor_rekening }}</td>
                                <td style="font-size: 12px;">{{ $rb->nama_pemilik }}</td>
                                <td style="font-size: 12px;">{{ $rb->cabang }}</td>
                                <td style="font-size: 12px;">{{ $rb->mata_uang }}</td>
                                <td style="font-size: 12px;">{{ 'Rp. ' .number_format($rb->saldo, 0, ".", ",") }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p style="font-size: 12px;">Tidak ada Informasi Rekening Bank</p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 12px;">Informasi Alamat</p>
                    @if($member->informasi_akun()->first()->area_member()->count() > 0)
                    <table class="table" style="width: 100%;">
                        <thead>
                            <th style="font-size: 12px;">Alamat Ke-</th>
                            <th style="font-size: 12px;">Provinsi</th>
                            <th style="font-size: 12px;">Kabupaten</th>
                            <th style="font-size: 12px;">Kecamatan</th>
                            <th style="font-size: 12px;">Desa</th>
                            <th style="font-size: 12px;">Alamat</th>
                            <th style="font-size: 12px;">Kode Pos</th>
                        </thead>
                        <tbody>
                            @foreach($member->informasi_akun()->first()->area_member()->get() as $am)
                            <tr style="width: 100%;">
                                <td style="font-size: 12px;">{{ $am->alamat_ke }}</td>
                                <td style="font-size: 12px;">{{ $am->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->nama_provinsi }}</td>
                                <td style="font-size: 12px;">{{ $am->desa()->first()->kecamatan()->first()->kabupaten()->first()->nama_kabupaten }}</td>
                                <td style="font-size: 12px;">{{ $am->desa()->first()->kecamatan()->first()->nama_kecamatan }}</td>
                                <td style="font-size: 12px;">{{ $am->desa()->first()->nama_desa }}</td>
                                <td style="font-size: 12px;">{{ $am->alamat }}</td>
                                <td style="font-size: 12px;">{{ $am->kode_pos }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Tidak Ada Area</p>
                    @endif
                </div>
            </div>
            @endif

            @if(!is_null($lembaga))
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 12px;">Informasi Lembaga</p>
                    <table class="table" style="width: 100%;margin: 1rem;">
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Status Anggota</td>
                            <td style="font-size: 12px; width: 50%">: {{ $lembaga->status_member()->first()->nama_status }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Nama Lembaga</td>
                            <td style="font-size: 12px; width: 50%">: {{ $lembaga->nama_lembaga }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">NPWP</td>
                            <td style="font-size: 12px; width: 50%">: {{ $lembaga->npwp()->first()->npwp }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Bidang Usaha</td>
                            <td style="font-size: 12px; width: 50%">: {{ $lembaga->bidang_usaha }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Email</td>
                            <td style="font-size: 12px; width: 50%">: {{ $lembaga->informasi_akun()->first()->email }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Nomor HP</td>
                            <td style="font-size: 12px; width: 50%">: {{ $lembaga->informasi_akun()->first()->no_hp }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Nomor WA</td>
                            <td style="font-size: 12px; width: 50%">: {{ $lembaga->informasi_akun()->first()->no_wa }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Nomor Fax</td>
                            <td style="font-size: 12px; width: 50%">: {{ $lembaga->informasi_akun()->first()->no_fax }}</td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="font-size: 12px; width: 50%">Username</td>
                            <td style="font-size: 12px; width: 50%">: {{ $lembaga->informasi_akun()->first()->userlogin()->first()->username }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 12px;">Jabatan Anggota Lembaga</p>
                    @if($lembaga->lembaga_informasi_pic()->count() > 0)
                    <table class="table" style="width: 100%;">
                        <thead>
                            <th style="font-size: 12px;">Nama</th>
                            <th style="font-size: 12px;">NIK</th>
                            <th style="font-size: 12px;">Jabatan</th>
                            <th style="font-size: 12px;">Status</th>
                        </thead>
                        <tbody>
                            @foreach($lembaga->lembaga_informasi_pic()->get() as $rb)
                            <tr style="width: 100%;">
                                <td style="font-size: 12px;">{{ $rb->member()->first()->ktp()->first()->nama }}</td>
                                <td style="font-size: 12px;">{{ $rb->member()->first()->ktp()->first()->nik }}</td>
                                <td style="font-size: 12px;">{{ $rb->jabatan }}</td>
                                <td style="font-size: 12px;">{{ $rb->is_aktif ? 'Aktif' : "Tidak" }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p style="font-size: 12px;">Tidak Ada PIC Lembaga yang terdaftar</p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 12px;">Informasi Rekening Bank</p>
                    @if($lembaga->informasi_akun()->first()->rekening_bank()->count() > 0)
                    <table class="table" style="width: 100%;">
                        <thead>
                            <th style="font-size: 12px;">Nomor Rekening</th>
                            <th style="font-size: 12px;">Nama</th>
                            <th style="font-size: 12px;">Cabang</th>
                            <th style="font-size: 12px;">Mata Uang</th>
                            <th style="font-size: 12px;">Saldo</th>
                        </thead>
                        <tbody>
                            @foreach($lembaga->informasi_akun()->first()->rekening_bank()->get() as $rb)
                            <tr style="width: 100%;">
                                <td style="font-size: 12px;">{{ $rb->nomor_rekening }}</td>
                                <td style="font-size: 12px;">{{ $rb->nama_pemilik }}</td>
                                <td style="font-size: 12px;">{{ $rb->cabang }}</td>
                                <td style="font-size: 12px;">{{ $rb->mata_uang }}</td>
                                <td style="font-size: 12px;">{{ 'Rp. ' .number_format($rb->saldo, 0, ".", ",") }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p style="font-size: 12px;">Tidak Ada Informasi Rekening Bank</p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p style="font-size: 12px;">Informasi Alamat</p>
                    @if($lembaga->informasi_akun()->first()->area_member()->count() > 0)
                    <table class="table" style="width: 100%;">
                        <thead>
                            <th style="font-size: 12px;">Alamat Ke-</th>
                            <th style="font-size: 12px;">Provinsi</th>
                            <th style="font-size: 12px;">Kabupaten</th>
                            <th style="font-size: 12px;">Kecamatan</th>
                            <th style="font-size: 12px;">Desa</th>
                            <th style="font-size: 12px;">Alamat</th>
                            <th style="font-size: 12px;">Kode Pos</th>
                        </thead>
                        <tbody>
                            @foreach($lembaga->informasi_akun()->first()->area_member()->get() as $am)
                            <tr style="width: 100%;">
                                <td style="font-size: 12px;">{{ $am->alamat_ke }}</td>
                                <td style="font-size: 12px;">{{ $am->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->nama_provinsi }}</td>
                                <td style="font-size: 12px;">{{ $am->desa()->first()->kecamatan()->first()->kabupaten()->first()->nama_kabupaten }}</td>
                                <td style="font-size: 12px;">{{ $am->desa()->first()->kecamatan()->first()->nama_kecamatan }}</td>
                                <td style="font-size: 12px;">{{ $am->desa()->first()->nama_desa }}</td>
                                <td style="font-size: 12px;">{{ $am->alamat }}</td>
                                <td style="font-size: 12px;">{{ $am->kode_pos }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Tidak Ada Area</p>
                    @endif
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <p style="font-size: 10px;font-style:italic;">Dicetak Pada: {{ now() }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
