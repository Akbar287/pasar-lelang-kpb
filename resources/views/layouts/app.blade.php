<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- General Info -->
    <meta name="nama" content="{{ is_null(Auth::user()->informasi_akun()->first()->member()) ? Auth::user()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : Auth::user()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}">
    <meta name="route" content="{{ Route::currentRouteName() }}">
    <meta name="id_user" content="{{ is_null(Auth::user()->informasi_akun()->first()->member()) ? Auth::user()->informasi_akun()->first()->lembaga()->first()->lembaga_id : Auth::user()->informasi_akun()->first()->member()->first()->member_id }}">
    <meta name="kartu" content="{{ asset('/images/KPB.png') }}">

    <title>{{ config('app.name', 'e-Lelang KPB') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Icon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Google Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <div class="div-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown d-flex">
                        <a href="{{ url('/profil') }}" class="nav-link nav-link-lg nav-link-user">
                            <img alt="profile"
                                src="{{ asset('/storage/profile_img/' . Auth::user()->informasi_akun()->first()->avatar) }}"
                                class="rounded-circle mr-1">
                        </a>
                        <a href="{{ url('/notifikasi') }}" class="nav-link nav-link-lg nav-link-user">
                            <i class="fas fa-bell"></i>
                        </a>
                        <a href="{{ route('logout') }}" class="nav-link nav-link-lg nav-link-user" id="logout-btn"
                            onclick="event.preventDefault();">
                            <i class="fas fa-sign-out-alt"></i>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand align-items-center">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('/images/e-kpb.png') }}" alt="logo" class="img-responsive" width="30">
                            {{ config('app.name', 'e-Lelang KPB') }}</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('/images/e-kpb.png') }}" alt="logo" class="img-responsive" width="30">
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Menu Utama</li>
                        <li class="{{ (Route::currentRouteName() == 'home') ? 'active': '' }}"><a class="nav-link" href="{{ url('/home') }}"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
                        
                        <li class="dropdown {{ (Route::currentRouteName() == 'master.anggota' || Route::currentRouteName() == 'master.kontrak' || Route::currentRouteName() == 'master.lembaga' || Route::currentRouteName() == 'master.lain' || Route::currentRouteName() == 'master.anggota.calon' || Route::currentRouteName() == 'master.anggota.calon.create' || Route::currentRouteName() == 'master.anggota.calon.show' || Route::currentRouteName() == 'master.anggota.calon.edit' || Route::currentRouteName() == 'master.anggota.verifikasi' || Route::currentRouteName() == 'master.anggota.verifikasi.show' || Route::currentRouteName() == 'master.anggota.list' || Route::currentRouteName() == 'master.anggota.list.create' || Route::currentRouteName() == 'master.anggota.list.suspend.index' || Route::currentRouteName() == 'master.anggota.list.show' || Route::currentRouteName() == 'master.anggota.list.rekening.index' || Route::currentRouteName() == 'master.anggota.list.rekening.create' || Route::currentRouteName() == 'master.anggota.list.rekening.show' || Route::currentRouteName() == 'master.anggota.list.rekening.edit' || Route::currentRouteName() == 'master.anggota.list.area.index' || Route::currentRouteName() == 'master.anggota.list.area.create' || Route::currentRouteName() == 'master.anggota.list.area.show' || Route::currentRouteName() == 'master.anggota.list.area.edit' || Route::currentRouteName() == 'master.anggota.list.dokumen.index' || Route::currentRouteName() == 'master.anggota.list.dokumen.create' || Route::currentRouteName() == 'master.anggota.list.dokumen.show' || Route::currentRouteName() == 'master.anggota.list.dokumen.edit' || Route::currentRouteName() == 'master.anggota.list.edit' || Route::currentRouteName() == 'master.anggota.perubahan' || Route::currentRouteName() == 'master.anggota.perubahan.create' || Route::currentRouteName() == 'master.anggota.perubahan.show' || Route::currentRouteName() == 'master.anggota.perubahan.edit' || Route::currentRouteName() == 'master.anggota.dibekukan' || Route::currentRouteName() == 'master.kontrak' || Route::currentRouteName() == 'master.kontrak.pengaturan' || Route::currentRouteName() == 'master.kontrak.pengaturan.create' || Route::currentRouteName() == 'master.kontrak.pengaturan.show' || Route::currentRouteName() == 'master.kontrak.pengaturan.edit' || Route::currentRouteName() == 'master.kontrak.verifikasi.riwayat' || Route::currentRouteName() == 'master.kontrak.verifikasi.riwayat.show' || Route::currentRouteName() == 'master.kontrak.verifikasi' || Route::currentRouteName() == 'master.kontrak.verifikasi.show' || Route::currentRouteName() == 'master.kontrak.list' || Route::currentRouteName() == 'master.kontrak.list.show' || Route::currentRouteName() == 'master.kontrak.list.edit' || Route::currentRouteName() == 'master.kontrak.nonaktif' || Route::currentRouteName() == 'master.kontrak.nonaktif.show' || Route::currentRouteName() == 'master.lembaga.bank' || Route::currentRouteName() == 'master.lembaga.bank.create' || Route::currentRouteName() == 'master.lembaga.bank.show' || Route::currentRouteName() == 'master.lembaga.bank.edit' || Route::currentRouteName() == 'master.lembaga.gudang' || Route::currentRouteName() == 'master.lembaga.gudang.create' || Route::currentRouteName() == 'master.lembaga.gudang.show' || Route::currentRouteName() == 'master.lembaga.gudang.edit' || Route::currentRouteName() == 'master.lain.sesi' || Route::currentRouteName() == 'master.lain.sesi.create' || Route::currentRouteName() == 'master.lain.sesi.show' || Route::currentRouteName() == 'master.lain.sesi.edit' || Route::currentRouteName() == 'master.lain.rekening' || Route::currentRouteName() == 'master.lain.rekening.create' || Route::currentRouteName() == 'master.lain.rekening.show' || Route::currentRouteName() == 'master.lain.rekening.edit' || Route::currentRouteName() == 'master.lain.komoditas' || Route::currentRouteName() == 'master.lain.komoditas.create' || Route::currentRouteName() == 'master.lain.komoditas.show' || Route::currentRouteName() == 'master.lain.komoditas.edit' || Route::currentRouteName() == 'master.lain.dokumen_persyaratan' || Route::currentRouteName() == 'master.lain.dokumen_persyaratan.create' || Route::currentRouteName() == 'master.lain.dokumen_persyaratan.show' || Route::currentRouteName() == 'master.lain.dokumen_persyaratan.edit' || Route::currentRouteName() == 'master.lain.hari_libur' || Route::currentRouteName() == 'master.lain.hari_libur.create' || Route::currentRouteName() == 'master.lain.hari_libur.show' || Route::currentRouteName() == 'master.lain.hari_libur.edit') ? 'active': '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-asterisk"></i> <span>Master Data</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ (Route::currentRouteName() == 'master.anggota' || Route::currentRouteName() == 'master.anggota.calon' || Route::currentRouteName() == 'master.anggota.calon.create' || Route::currentRouteName() == 'master.anggota.calon.show' || Route::currentRouteName() == 'master.anggota.calon.edit' || Route::currentRouteName() == 'master.anggota.verifikasi' || Route::currentRouteName() == 'master.anggota.verifikasi.show' || Route::currentRouteName() == 'master.anggota.list' || Route::currentRouteName() == 'master.anggota.list.create' || Route::currentRouteName() == 'master.anggota.list.suspend.index' || Route::currentRouteName() == 'master.anggota.list.show' || Route::currentRouteName() == 'master.anggota.list.rekening.index' || Route::currentRouteName() == 'master.anggota.list.rekening.create' || Route::currentRouteName() == 'master.anggota.list.rekening.show' || Route::currentRouteName() == 'master.anggota.list.rekening.edit' || Route::currentRouteName() == 'master.anggota.list.area.index' || Route::currentRouteName() == 'master.anggota.list.area.create' || Route::currentRouteName() == 'master.anggota.list.area.show' || Route::currentRouteName() == 'master.anggota.list.area.edit' || Route::currentRouteName() == 'master.anggota.list.dokumen.index' || Route::currentRouteName() == 'master.anggota.list.dokumen.create' || Route::currentRouteName() == 'master.anggota.list.dokumen.show' || Route::currentRouteName() == 'master.anggota.list.dokumen.edit' || Route::currentRouteName() == 'master.anggota.list.edit' || Route::currentRouteName() == 'master.anggota.perubahan' || Route::currentRouteName() == 'master.anggota.perubahan.create' || Route::currentRouteName() == 'master.anggota.perubahan.show' || Route::currentRouteName() == 'master.anggota.perubahan.edit' || Route::currentRouteName() == 'master.anggota.dibekukan') ? 'active': '' }}"><a class="nav-link" href="{{ url('/master/anggota') }}">Anggota Pasar lelang</a></li>
                                <li class="{{ (Route::currentRouteName() == 'master.kontrak' || Route::currentRouteName() == 'master.kontrak.pengaturan' || Route::currentRouteName() == 'master.kontrak.pengaturan.create' || Route::currentRouteName() == 'master.kontrak.pengaturan.show' || Route::currentRouteName() == 'master.kontrak.pengaturan.edit' || Route::currentRouteName() == 'master.kontrak.verifikasi.riwayat' || Route::currentRouteName() == 'master.kontrak.verifikasi.riwayat.show' || Route::currentRouteName() == 'master.kontrak.verifikasi' || Route::currentRouteName() == 'master.kontrak.verifikasi.show' || Route::currentRouteName() == 'master.kontrak.list' || Route::currentRouteName() == 'master.kontrak.list.show' || Route::currentRouteName() == 'master.kontrak.list.edit' || Route::currentRouteName() == 'master.kontrak.nonaktif' || Route::currentRouteName() == 'master.kontrak.nonaktif.show') ? 'active': '' }}"><a class="nav-link" href="{{ url('/master/kontrak') }}">Kontrak Pasar lelang</a></li>
                                <li class="{{ (Route::currentRouteName() == 'master.lembaga' || Route::currentRouteName() == 'master.lembaga.bank' || Route::currentRouteName() == 'master.lembaga.bank.create' || Route::currentRouteName() == 'master.lembaga.bank.show' || Route::currentRouteName() == 'master.lembaga.bank.edit' || Route::currentRouteName() == 'master.lembaga.gudang' || Route::currentRouteName() == 'master.lembaga.gudang.create' || Route::currentRouteName() == 'master.lembaga.gudang.show' || Route::currentRouteName() == 'master.lembaga.gudang.edit') ? 'active': '' }}"><a class="nav-link" href="{{ url('/master/lembaga') }}">Lembaga Pendukung</a></li>
                                <li class="{{ (Route::currentRouteName() == 'master.lain' || Route::currentRouteName() == 'master.lain.sesi' || Route::currentRouteName() == 'master.lain.sesi.create' || Route::currentRouteName() == 'master.lain.sesi.show' || Route::currentRouteName() == 'master.lain.sesi.edit' || Route::currentRouteName() == 'master.lain.rekening' || Route::currentRouteName() == 'master.lain.rekening.create' || Route::currentRouteName() == 'master.lain.rekening.show' || Route::currentRouteName() == 'master.lain.rekening.edit' || Route::currentRouteName() == 'master.lain.komoditas' || Route::currentRouteName() == 'master.lain.komoditas.create' || Route::currentRouteName() == 'master.lain.komoditas.show' || Route::currentRouteName() == 'master.lain.komoditas.edit' || Route::currentRouteName() == 'master.lain.dokumen_persyaratan' || Route::currentRouteName() == 'master.lain.dokumen_persyaratan.create' || Route::currentRouteName() == 'master.lain.dokumen_persyaratan.show' || Route::currentRouteName() == 'master.lain.dokumen_persyaratan.edit' || Route::currentRouteName() == 'master.lain.hari_libur' || Route::currentRouteName() == 'master.lain.hari_libur.create' || Route::currentRouteName() == 'master.lain.hari_libur.show' || Route::currentRouteName() == 'master.lain.hari_libur.edit') ? 'active': '' }}"><a class="nav-link" href="{{ url('/master/lain') }}">Master Lainnya</a></li>
                            </ul>
                        </li>

                        <li class="dropdown {{ (Route::currentRouteName() == 'transaksi.lelang_baru' || Route::currentRouteName() == 'transaksi.lelang_baru.create' || Route::currentRouteName() == 'transaksi.lelang_baru.show' || Route::currentRouteName() == 'transaksi.verifikasi_lelang' || Route::currentRouteName() == 'transaksi.verifikasi_lelang.show' || Route::currentRouteName() == 'transaksi.verifikasi_lelang.ditolak' || Route::currentRouteName() == 'transaksi.verifikasi_lelang.show.ditolak' || Route::currentRouteName() == 'transaksi.lelang_baru.edit' || Route::currentRouteName() == 'transaksi.lelang_list' || Route::currentRouteName() == 'transaksi.lelang_list.show' || Route::currentRouteName() == 'transaksi.lelang_list.edit' || Route::currentRouteName() == 'transaksi.lelang_baru.file' || Route::currentRouteName() == 'transaksi.lelang_baru.file.create' || Route::currentRouteName() == 'transaksi.lelang_baru.file.show' || Route::currentRouteName() == 'transaksi.lelang_baru.file.edit' || Route::currentRouteName() == 'transaksi.lelang_list.file' || Route::currentRouteName() == 'transaksi.lelang_list.file.create' || Route::currentRouteName() == 'transaksi.lelang_list.file.show' || Route::currentRouteName() == 'transaksi.lelang_list.file.edit') ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-credit-card"></i> <span>Transaksi Psr.lelang</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ (Route::currentRouteName() == 'transaksi.lelang_baru' || Route::currentRouteName() == 'transaksi.lelang_baru.create' || Route::currentRouteName() == 'transaksi.lelang_baru.show' || Route::currentRouteName() == 'transaksi.lelang_baru.edit' || Route::currentRouteName() == 'transaksi.lelang_baru.file' || Route::currentRouteName() == 'transaksi.lelang_baru.file.create' || Route::currentRouteName() == 'transaksi.lelang_baru.file.show' || Route::currentRouteName() == 'transaksi.lelang_baru.file.edit') ? 'active': '' }}"><a class="nav-link" href="{{ url('/transaksi/lelang_baru') }}">Lelang Baru</a></li>
                                <li class="{{ (Route::currentRouteName() == 'transaksi.verifikasi_lelang' || Route::currentRouteName() == 'transaksi.verifikasi_lelang.show' || Route::currentRouteName() == 'transaksi.verifikasi_lelang.ditolak' || Route::currentRouteName() == 'transaksi.verifikasi_lelang.show.ditolak') ? 'active': '' }}"><a class="nav-link" href="{{ url('/transaksi/verifikasi_lelang') }}">Verifikasi Lelang</a></li>
                                <li class="{{ (Route::currentRouteName() == 'transaksi.lelang_list' || Route::currentRouteName() == 'transaksi.lelang_list.show' || Route::currentRouteName() == 'transaksi.lelang_list.edit' || Route::currentRouteName() == 'transaksi.lelang_list.file' || Route::currentRouteName() == 'transaksi.lelang_list.file.create' || Route::currentRouteName() == 'transaksi.lelang_list.file.show' || Route::currentRouteName() == 'transaksi.lelang_list.file.edit') ? 'active': '' }}"><a class="nav-link" href="{{ url('/transaksi/list_lelang') }}">Daftar Lelang</a></li>
                            </ul>
                        </li>                                                               

                        <li class="dropdown {{ Route::currentRouteName() == 'administrasi.kas_bank' || Route::currentRouteName() == 'administrasi.kas_bank.penerimaan.index' || Route::currentRouteName() == 'administrasi.kas_bank.penerimaan.create' || Route::currentRouteName() == 'administrasi.kas_bank.penerimaan.show' || Route::currentRouteName() == 'administrasi.kas_bank.penerimaan.edit' || Route::currentRouteName() == 'administrasi.kas_bank.verifikasi.index_ditolak' || Route::currentRouteName() == 'administrasi.kas_bank.verifikasi.show_ditolak' || Route::currentRouteName() == 'administrasi.kas_bank.verifikasi.index' || Route::currentRouteName() == 'administrasi.kas_bank.verifikasi.show' || Route::currentRouteName() == 'administrasi.kas_bank.list.index' || Route::currentRouteName() == 'administrasi.kas_bank.list.show' ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-credit-card"></i> <span>Administrasi Psr.lelang</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ (Route::currentRouteName() == 'administrasi.kas_bank' || Route::currentRouteName() == 'administrasi.kas_bank.penerimaan.index' || Route::currentRouteName() == 'administrasi.kas_bank.penerimaan.create' || Route::currentRouteName() == 'administrasi.kas_bank.penerimaan.show' || Route::currentRouteName() == 'administrasi.kas_bank.penerimaan.edit' || Route::currentRouteName() == 'administrasi.kas_bank.verifikasi.index_ditolak' || Route::currentRouteName() == 'administrasi.kas_bank.verifikasi.show_ditolak' || Route::currentRouteName() == 'administrasi.kas_bank.verifikasi.index' || Route::currentRouteName() == 'administrasi.kas_bank.verifikasi.show' || Route::currentRouteName() == 'administrasi.kas_bank.list.index' || Route::currentRouteName() == 'administrasi.kas_bank.list.show') ? 'active': '' }}"><a class="nav-link" href="{{ url('/administrasi/kas_bank') }}">Kas dan Bank</a></li>
                                <li class="{{ (Route::currentRouteName() == 'administrasi.gudang') ? 'active': '' }}"><a class="nav-link" href="{{ url('/administrasi/gudang') }}">Gudang</a></li>
                                <li class="{{ (Route::currentRouteName() == 'administrasi.jaminan') ? 'active': '' }}"><a class="nav-link" href="{{ url('/administrasi/jaminan_lelang') }}">Jaminan Lelang</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-cogs"></i> <span>Operational Psr.lelang</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ (Route::currentRouteName() == 'operational.transaksi') ? 'active': '' }}"><a class="nav-link" href="{{ url('/operational/transaksi') }}">Transaksi Lelang</a></li>
                                <li class="{{ (Route::currentRouteName() == 'operational.verifikasi') ? 'active': '' }}"><a class="nav-link" href="{{ url('/operational/verifikasi') }}">Verifikasi Transaksi Lelang</a></li>
                                <li class="{{ (Route::currentRouteName() == 'operational.transaksi_selesai') ? 'active': '' }}"><a class="nav-link" href="{{ url('/operational/transaksi_selesai') }}">Transaksi lelang Selesai</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-file"></i> <span>Laporan</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ (Route::currentRouteName() == 'petty-cash') ? 'active': '' }}"><a class="nav-link" href="{{ url('/financial/petty-cash') }}">Laporan Jaminan</a></li>
                                <li class="{{ (Route::currentRouteName() == 'laba-rugi') ? 'active': '' }}"><a class="nav-link" href="{{ url('/financial/laba-rugi') }}">Laporan Transaksi Lelang</a></li>
                                <li class="{{ (Route::currentRouteName() == 'neraca') ? 'active': '' }}"><a class="nav-link" href="{{ url('/financial/neraca') }}">Laporan Transaksi Bank</a></li>
                                <li class="{{ (Route::currentRouteName() == 'neraca') ? 'active': '' }}"><a class="nav-link" href="{{ url('/financial/neraca') }}">Daftar Anggota</a></li>
                                <li class="{{ (Route::currentRouteName() == 'neraca') ? 'active': '' }}"><a class="nav-link" href="{{ url('/financial/neraca') }}">Event Lelang Offline</a></li>
                            </ul>
                        </li>

                        <li class="dropdown {{ (Route::currentRouteName() == 'online' || Route::currentRouteName() == 'online.event' || Route::currentRouteName() == 'online.event.show' || Route::currentRouteName() == 'online.event.produk' || Route::currentRouteName() == 'online.event.produk.show' || Route::currentRouteName() == 'online.event.produk.sesi' || Route::currentRouteName() == 'online.event.anggota' || Route::currentRouteName() == 'online.event.anggota.create' || Route::currentRouteName() == 'online.event.anggota.show' || Route::currentRouteName() == 'online.event.anggota.edit') ? 'active': '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-globe"></i> <span>Lelang Online</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ (Route::currentRouteName() == 'online.event' || Route::currentRouteName() == 'online.event.show' || Route::currentRouteName() == 'online.event.produk' || Route::currentRouteName() == 'online.event.produk.show' || Route::currentRouteName() == 'online.event.produk.sesi' || Route::currentRouteName() == 'online.event.anggota' || Route::currentRouteName() == 'online.event.anggota.create' || Route::currentRouteName() == 'online.event.anggota.show' || Route::currentRouteName() == 'online.event.anggota.edit') ? 'active': '' }}"><a class="nav-link" href="{{ url('/online/event') }}">Event Lelang Online</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown {{ (Route::currentRouteName() == 'offline.profile' || Route::currentRouteName() == 'offline.profile.create' || Route::currentRouteName() == 'offline.profile.show' || Route::currentRouteName() == 'offline.profile.edit' || Route::currentRouteName() == 'offline.operator' || Route::currentRouteName() == 'offline.operator.create' || Route::currentRouteName() == 'offline.operator.show' || Route::currentRouteName() == 'offline.operator.edit' || Route::currentRouteName() == 'offline.event' || Route::currentRouteName() == 'offline.event.create' || Route::currentRouteName() == 'offline.event.show' || Route::currentRouteName() == 'offline.event.edit' || Route::currentRouteName() == 'offline.event.produk.show' || Route::currentRouteName() == 'offline.event.produk'|| Route::currentRouteName() == 'offline.event.produk.sesi') ? 'active': '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-building"></i> <span>Lelang Offline</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ (Route::currentRouteName() == 'offline.profile' || Route::currentRouteName() == 'offline.profile.create' || Route::currentRouteName() == 'offline.profile.show' || Route::currentRouteName() == 'offline.profile.edit') ? 'active': '' }}"><a class="nav-link" href="{{ url('/offline/profile') }}">Offline Profile</a></li>
                                <li class="{{ (Route::currentRouteName() == 'offline.operator' || Route::currentRouteName() == 'offline.operator.create' || Route::currentRouteName() == 'offline.operator.show' || Route::currentRouteName() == 'offline.operator.edit') ? 'active': '' }}"><a class="nav-link" href="{{ url('/offline/operator') }}">Operator lelang Offline</a></li>
                                <li class="{{ (Route::currentRouteName() == 'offline.event' || Route::currentRouteName() == 'offline.event.create' || Route::currentRouteName() == 'offline.event.show' || Route::currentRouteName() == 'offline.event.edit' || Route::currentRouteName() == 'offline.event.produk.show' || Route::currentRouteName() == 'offline.event.produk'|| Route::currentRouteName() == 'offline.event.produk.sesi') ? 'active': '' }}"><a class="nav-link" href="{{ url('/offline/event') }}">Event Lelang Offline</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-wrench"></i> <span>Konfigurasi</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ (Route::currentRouteName() == 'petty-cash') ? 'active': '' }}"><a class="nav-link" href="{{ url('/financial/petty-cash') }}">Role</a></li>
                                <li class="{{ (Route::currentRouteName() == 'laba-rugi') ? 'active': '' }}"><a class="nav-link" href="{{ url('/financial/laba-rugi') }}">Jenis Inisiasi</a></li>
                                <li class="{{ (Route::currentRouteName() == 'neraca') ? 'active': '' }}"><a class="nav-link" href="{{ url('/financial/neraca') }}">Jenis Perdagangan</a></li>
                                <li class="{{ (Route::currentRouteName() == 'neraca') ? 'active': '' }}"><a class="nav-link" href="{{ url('/financial/neraca') }}">Jenis Suspend</a></li>
                                <li class="{{ (Route::currentRouteName() == 'neraca') ? 'active': '' }}"><a class="nav-link" href="{{ url('/financial/neraca') }}">Jenis Status member</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </aside>
            </div>
            <div class="main-content">
                <section class="section">
                    @yield('content')
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    {{ config('app.name', 'e-Lelang KPB') }} <div class="bullet"></div> {{ now()->year }}   
                </div>
            </footer>
        </div>
    </div>
</body>

</html>