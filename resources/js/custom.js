"use strict";

const { default: Swal } = require("sweetalert2");
import Cleave from "cleave.js";
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

$(function () {
    let penawaranPadaHargaSatuan = null;
    let routeName = ($('meta[name=route]')[0].content);
    let csrf = ($('meta[name=csrf-token]')[0].content);
    let role = '';
    if (routeName != 'login') {
        role = ($('meta[name=role]')[0].content);
    }

    console.log(routeName)

    if(penawaranPadaHargaSatuan == null) {
        if(location.href.includes('/transaksi/lelang') || location.href.includes('/lelang/pengajuan')) {
            $.ajax({
                url: document.location.origin + '/transaksi/lelang/cek_penawaran_pada_harga_satuan_id',
                method: 'get',
                dataType: 'json',
                success: function(res) {
                    penawaranPadaHargaSatuan = res.data
                },
                error: function(err) {console.error(err);}
            })
        }
    }
    if(routeName == 'home.saldo') {
        $('.table-rekening-bank').DataTable();
    }
    if (routeName == 'login') {
        $('#see_password').on('click', function () {
            if($(this).parent().siblings().attr('type') == 'password'){
                $(this).parent().siblings().attr('type', 'text');
            } else {
                $(this).parent().siblings().attr('type', 'password');
            }
        });
    }
    if($('.thousand-style').toArray().length > 0) {
        $('.thousand-style').toArray().forEach(x => {
            new Cleave(x, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
        });
    }
    if (routeName == 'home') {
        if(role !== 'ROLE_DINAS') {
            $.ajax({
                url: document.location.origin + '/home/api',
                data: {
                    _token: csrf,
                    jenis: 'transaksi_lelang',
                },
                dataType: 'json',
                method: 'get',
                beforeSend: function() {},
                success: function(res) {
                    new Chart(document.getElementById("chart_primary").getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ["Online", "Offline", "Hybrid"],
                            datasets: [{
                                label: 'Transaksi Lelang',
                                data: [res.data.lelang.online, res.data.lelang.offline, res.data.lelang.hybrid],
                                borderWidth: 5,
                                borderColor: '#6777ef',
                                backgroundColor: 'transparent',
                                pointBorderColor: '#6777ef',
                                pointRadius: 4
                            }]
                        },
                    });
                    new Chart(document.getElementById("chart_secondary").getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ["Online", "Offline", "Hybrid"],
                            datasets: [{
                                label: 'Produk Di Lelang',
                                data: [res.data.produk.online, res.data.produk.offline, res.data.produk.hybrid],
                                borderWidth: 5,
                                borderColor: '#6777ef',
                                backgroundColor: 'transparent',
                                pointBorderColor: '#6777ef',
                                pointRadius: 4
                            }]
                        },
                    });
                },
                error: function(err) {
                    console.error(err);
                }
            });
        } else {
            // Grafik

            // Saldo Jaminan
            $.ajax({
                url: document.location.origin + '/eksekutif/api/saldo-jaminan',
                data: {
                    _token: csrf,
                    type: 'grafik_sebaran',
                },
                dataType: 'json',
                method: 'get',
                beforeSend: function() {},
                success: function(res) {
                    if(res.status == 'success') {
                        new Chart(document.getElementById("chart_summary_jaminan_main").getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: [
                                    'Saldo Teralokasi',
                                    'Saldo Tersedia (Bebas)'
                                ],
                                datasets: [{
                                    label: 'Sebaran Saldo Jaminan',
                                    data: [res.data.saldo_teralokasi, res.data.saldo_tersedia],
                                    backgroundColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(54, 162, 235)'
                                    ],
                                    hoverOffset: 4
                                }]
                            },
                        });
                        new Chart(document.getElementById("chart_summary_jaminan").getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: [
                                    'Saldo Teralokasi',
                                    'Saldo Tersedia (Bebas)'
                                ],
                                datasets: [{
                                    label: 'Sebaran Saldo Jaminan',
                                    data: [res.data.saldo_teralokasi, res.data.saldo_tersedia],
                                    backgroundColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(54, 162, 235)'
                                    ],
                                    hoverOffset: 4
                                }]
                            },
                        });

                        $('td#saldo_teralokasi').html(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.saldo_teralokasi) )
                        $('td#saldo_tersedia').html(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.saldo_tersedia) )
                    }
                },
                error: function(err) {
                    console.error(err);
                }
            });

            // Kontrak
            $.ajax({
                url: document.location.origin + '/eksekutif/api/kontrak',
                data: {
                    _token: csrf,
                    type: 'grafik_sebaran',
                },
                dataType: 'json',
                method: 'get',
                beforeSend: function() {},
                success: function(res) {
                    if(res.status == 'success') {
                        new Chart(document.getElementById("chart_komoditas_jaminan_main").getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: res.data.komoditas.label,
                                datasets: [{
                                    label: 'Kontrak by Komoditas',
                                    data: res.data.komoditas.data,
                                    backgroundColor: res.data.komoditas.bg,
                                    hoverOffset: 4
                                }]
                            },
                        });
                        new Chart(document.getElementById("chart_perdagangan_jaminan").getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: res.data.perdagangan.label,
                                datasets: [{
                                    label: 'Kontrak by Jenis Perdagangan',
                                    data: res.data.perdagangan.data,
                                    backgroundColor: res.data.perdagangan.bg,
                                    hoverOffset: 4
                                }]
                            },
                        });
                    }
                },
                error: function(err) {
                    console.error(err);
                }
            });

            // Produk Lelang
            $.ajax({
                url: document.location.origin + '/eksekutif/api/produk',
                data: {
                    _token: csrf,
                    type: 'grafik_sebaran',
                },
                dataType: 'json',
                method: 'get',
                beforeSend: function() {},
                success: function(res) {
                    if(res.status == 'success') {
                        new Chart(document.getElementById("chart_pelelangan_produk").getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: [
                                    'Sukses Terjual',
                                    'Belum Terjual'
                                ],
                                datasets: [{
                                    label: 'Produk lelang Terjual',
                                    data: [
                                        res.data.lelang_sukses.sukses,
                                        res.data.lelang_sukses.semua - res.data.lelang_sukses.sukses,
                                    ],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)'
                                    ],
                                    hoverOffset: 4
                                }]
                            },
                        });
                        new Chart(document.getElementById("chart_platform_produk").getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: [
                                    'online',
                                    'offline',
                                    'hybrid'
                                ],
                                datasets: [{
                                    label: 'Platform Produk lelang',
                                    data: [
                                        res.data.lelang_platform.online,
                                        res.data.lelang_platform.offline,
                                        res.data.lelang_platform.hybrid
                                    ],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(170, 120, 132)',
                                        'rgb(54, 162, 235)'
                                    ],
                                    hoverOffset: 4
                                }]
                            },
                        });
                    }
                },
                error: function(err) {
                    console.error(err);
                }
            });

            $('#event_lelang_id').select2({
                minimumInputLength: 2,
                tags: [],
                ajax: {
                    url: document.location.origin + '/laporan/event_lelang/api',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params) {
                        return {
                            token: csrf,
                            q: params.term, // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.nama_lelang + ' (' + item.event_kode + ')',
                                    id: item.event_lelang_id
                                }
                            })
                        };
                    },
                    cache: true
                },
            });

            // End Grafik
            $('select[name=laporan]').on('change', function(e) {
                let selectMenu = $('select[name=laporan]').val();
                console.log(selectMenu);

                if(selectMenu == 'main_menu') {
                    $('.display-all').addClass('d-none')
                    $('.display-all.main-menu-view').removeClass('d-none')
                }
                if(selectMenu == 'anggota') {
                    $('.display-all').addClass('d-none')
                    $('.display-all.anggota-view').removeClass('d-none')
                }
                if(selectMenu == 'saldo_jaminan') {
                    $('.display-all').addClass('d-none')
                    $('.display-all.saldo_jaminan-view').removeClass('d-none')
                }
                if(selectMenu == 'kontrak_lelang') {
                    $('.display-all').addClass('d-none')
                    $('.display-all.kontrak_lelang-view').removeClass('d-none')
                }
                if(selectMenu == 'produk_lelang') {
                    $('.display-all').addClass('d-none')
                    $('.display-all.produk_lelang-view').removeClass('d-none')
                }
                if(selectMenu == 'event_lelang') {
                    $('.display-all').addClass('d-none');
                    $('.display-all.event_lelang-view').removeClass('d-none');

                    $('#event_lelang_id').on('change', function(e) {
                        $.ajax({
                            url: document.location.origin + '/eksekutif/api/event',
                            data: {
                                _token: csrf,
                                type: 'event_detail',
                                data: e.target.value
                            },
                            dataType: 'json',
                            method: 'get',
                            beforeSend: function() {
                                $('#event_kode').text('Loading...');
                                $('#jam_mulai').text('Loading...');
                                $('#nama_lelang').text('Loading...');
                                $('#jam_selesai').text('Loading...');
                                $('#tanggal').text('Loading...');
                                $('#total_peserta').text('Loading...');
                                $('#lokasi').text('Loading...');
                                $('#total_produk').text('Loading...');
                                $('#ketua_lelang').text('Loading...');
                                $('#status').text('Loading...');
                                $('#total_penjualan_lelang').text('Loading...');
                                $('tbody#peserta_event').append('<tr><td colspan="2">Loading...</td></tr>')
                                $('tbody#penjual_event').append('<tr><td colspan="3">Loading...</td></tr>')
                                $('tbody#produk_lelang').append('<tr><td colspan="7">Loading...</td></tr>')
                            },
                            success: function(res) {
                                if(res.status == 'success') {
                                    $('#event_kode').text(res.data.deskripsi.event_kode);
                                    $('#jam_mulai').text(res.data.deskripsi.jam_mulai);
                                    $('#nama_lelang').text(res.data.deskripsi.nama_lelang);
                                    $('#jam_selesai').text(res.data.deskripsi.jam_selesai);
                                    $('#tanggal').text(res.data.deskripsi.tanggal_lelang);
                                    $('#total_peserta').text(res.data.deskripsi.total_peserta);
                                    $('#lokasi').text(res.data.deskripsi.lokasi);
                                    $('#total_produk').text(res.data.deskripsi.total_produk);
                                    $('#ketua_lelang').text(res.data.deskripsi.ketua_lelang);
                                    $('#status').text(res.data.deskripsi.status);
                                    $('#total_penjualan_lelang').text(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.deskripsi.total_penjualan));
                                    $('tbody#peserta_event').children().remove();
                                    $('tbody#penjual_event').children().remove();
                                    $('tbody#produk_lelang').children().remove();

                                    let peserta = '';
                                    for(let i = 0; i < res.data.peserta.length; i++) {
                                        peserta += '<tr><td>'+ res.data.peserta[i].kode_peserta_lelang +'</td><td>'+ res.data.peserta[i].nama +'</td></tr>';
                                    }
                                    $('tbody#peserta_event').append(peserta);

                                    peserta = '';
                                    for(let i = 0; i < res.data.penjual.length; i++) {
                                        peserta += '<tr><td>'+ (i + 1) +'</td><td>'+ res.data.penjual[i].nama_penjual +'</td><td>'+ res.data.penjual[i].komoditas +'</td></tr>';
                                    }
                                    $('tbody#penjual_event').append(peserta);

                                    peserta = '';
                                    for(let i = 0; i < res.data.produk.length; i++) {
                                        peserta += '<tr><td>'+ res.data.produk[i].nomor_lelang +'</td><td>'+ res.data.produk[i].komoditas +'</td><td>'+ res.data.produk[i].judul +'</td><td>'+ Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.produk[i].harga_awal) +'</td><td>'+ Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.produk[i].kelipatan) +'</td><td>'+ Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.produk[i].harga_pemenang) +'</td><td>'+ res.data.produk[i].status +'</td></tr>';
                                    }
                                    $('tbody#produk_lelang').append(peserta);


                                } else {
                                    $('#event_kode').text('Terjadi Kesalahan...');
                                    $('#jam_mulai').text('Terjadi Kesalahan...');
                                    $('#nama_lelang').text('Terjadi Kesalahan...');
                                    $('#jam_selesai').text('Terjadi Kesalahan...');
                                    $('#tanggal').text('Terjadi Kesalahan...');
                                    $('#total_peserta').text('Terjadi Kesalahan...');
                                    $('#lokasi').text('Terjadi Kesalahan...');
                                    $('#total_produk').text('Terjadi Kesalahan...');
                                    $('#ketua_lelang').text('Terjadi Kesalahan...');
                                    $('#status').text('Terjadi Kesalahan...');
                                    $('#total_penjualan_lelang').text('Terjadi Kesalahan...');
                                    $('tbody#peserta_event').children().remove().append('<tr><td colspan="2">Terjadi Kesalahan...</td></tr>')
                                    $('tbody#penjual_event').children().remove().append('<tr><td colspan="3">Terjadi Kesalahan...</td></tr>')
                                    $('tbody#produk_lelang').children().remove().append('<tr><td colspan="7">Terjadi Kesalahan...</td></tr>')
                                }
                            },
                            error: function(err) {
                                console.error(err);
                                    $('#event_kode').text('Error...');
                                    $('#jam_mulai').text('Error...');
                                    $('#nama_lelang').text('Error...');
                                    $('#jam_selesai').text('Error...');
                                    $('#tanggal').text('Error...');
                                    $('#total_peserta').text('Error...');
                                    $('#lokasi').text('Error...');
                                    $('#total_produk').text('Error...');
                                    $('#ketua_lelang').text('Error...');
                                    $('#status').text('Error...');
                                    $('#total_penjualan_lelang').text('Error...');
                                    $('tbody#peserta_event').children().remove().append('<tr><td colspan="2">Error...</td></tr>')
                                    $('tbody#penjual_event').children().remove().append('<tr><td colspan="3">Error...</td></tr>')
                                    $('tbody#produk_lelang').children().remove().append('<tr><td colspan="7">Error...</td></tr>')
                            }
                        });
                    })
                }

                if(selectMenu == 'transaksi_lelang') {
                    $('.display-all').addClass('d-none')
                    $('.display-all.transaksi_lelang-view').removeClass('d-none')
                }
            })


            $('.table-anggota').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
                },
            });
        }

    }

    if(routeName == 'eksekutif.anggota') {
        $('.table-anggota').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
        });
    }
    if(routeName == 'eksekutif.saldo-jaminan') {
        $('.table-anggota').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
        });
        $.ajax({
            url: document.location.origin + '/eksekutif/api/saldo-jaminan',
            data: {
                _token: csrf,
                type: 'grafik_sebaran',
            },
            dataType: 'json',
            method: 'get',
            beforeSend: function() {},
            success: function(res) {
                if(res.status == 'success') {
                    new Chart(document.getElementById("chart_summary_jaminan").getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: [
                                'Saldo Teralokasi',
                                'Saldo Tersedia (Bebas)'
                            ],
                            datasets: [{
                                label: 'Sebaran Saldo Jaminan',
                                data: [res.data.saldo_teralokasi, res.data.saldo_tersedia],
                                backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)'
                                ],
                                hoverOffset: 4
                            }]
                        },
                    });

                    $('td#saldo_teralokasi').html(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.saldo_teralokasi) )
                    $('td#saldo_tersedia').html(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.saldo_tersedia) )
                }
            },
            error: function(err) {
                console.error(err);
            }
        });
    }
    if(routeName == 'eksekutif.kontrak-lelang') {
        $('.table-anggota').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
        });
        $.ajax({
            url: document.location.origin + '/eksekutif/api/kontrak',
            data: {
                _token: csrf,
                type: 'grafik_sebaran',
            },
            dataType: 'json',
            method: 'get',
            beforeSend: function() {},
            success: function(res) {
                if(res.status == 'success') {
                    new Chart(document.getElementById("chart_komoditas_jaminan").getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: res.data.komoditas.label,
                            datasets: [{
                                label: 'Kontrak by Komoditas',
                                data: res.data.komoditas.data,
                                backgroundColor: res.data.komoditas.bg,
                                hoverOffset: 4
                            }]
                        },
                    });
                    new Chart(document.getElementById("chart_perdagangan_jaminan").getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: res.data.perdagangan.label,
                            datasets: [{
                                label: 'Kontrak by Jenis Perdagangan',
                                data: res.data.perdagangan.data,
                                backgroundColor: res.data.perdagangan.bg,
                                hoverOffset: 4
                            }]
                        },
                    });
                }
            },
            error: function(err) {
                console.error(err);
            }
        });
    }
    if(routeName == 'eksekutif.produk-lelang') {
        $('.table-anggota').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
        });
        $.ajax({
            url: document.location.origin + '/eksekutif/api/produk',
            data: {
                _token: csrf,
                type: 'grafik_sebaran',
            },
            dataType: 'json',
            method: 'get',
            beforeSend: function() {},
            success: function(res) {
                if(res.status == 'success') {
                    new Chart(document.getElementById("chart_pelelangan_produk").getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: [
                                'Sukses Terjual',
                                'Belum Terjual'
                            ],
                            datasets: [{
                                label: 'Produk lelang Terjual',
                                data: [
                                    res.data.lelang_sukses.sukses,
                                    res.data.lelang_sukses.semua - res.data.lelang_sukses.sukses,
                                ],
                                backgroundColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(54, 162, 235)'
                                ],
                                hoverOffset: 4
                            }]
                        },
                    });
                    new Chart(document.getElementById("chart_platform_produk").getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: [
                                'online',
                                'offline',
                                'hybrid'
                            ],
                            datasets: [{
                                label: 'Platform Produk lelang',
                                data: [
                                    res.data.lelang_platform.online,
                                    res.data.lelang_platform.offline,
                                    res.data.lelang_platform.hybrid
                                ],
                                backgroundColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(170, 120, 132)',
                                    'rgb(54, 162, 235)'
                                ],
                                hoverOffset: 4
                            }]
                        },
                    });
                }
            },
            error: function(err) {
                console.error(err);
            }
        });

        $('#event_lelang_id').select2({
            minimumInputLength: 2,
            tags: [],
            ajax: {
                url: document.location.origin + '/laporan/event_lelang/api',
                dataType: 'json',
                delay: 250,
                type: 'GET',
                data: function (params) {
                    return {
                        token: csrf,
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.nama_lelang + ' (' + item.event_kode + ')',
                                id: item.event_lelang_id
                            }
                        })
                    };
                },
                cache: true
            },
        });
    }
    if (routeName == 'eksekutif.event-lelang') {
        $('.table-anggota').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
        });
        $('#event_lelang_id').select2({
            minimumInputLength: 2,
            tags: [],
            ajax: {
                url: document.location.origin + '/laporan/event_lelang/api',
                dataType: 'json',
                delay: 250,
                type: 'GET',
                data: function (params) {
                    return {
                        token: csrf,
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.nama_lelang + ' (' + item.event_kode + ')',
                                id: item.event_lelang_id
                            }
                        })
                    };
                },
                cache: true
            },
        });
        $('#event_lelang_id').on('change', function(e) {
            $.ajax({
                url: document.location.origin + '/eksekutif/api/event',
                data: {
                    _token: csrf,
                    type: 'event_detail',
                    data: e.target.value
                },
                dataType: 'json',
                method: 'get',
                beforeSend: function() {
                    $('#event_kode').text('Loading...');
                    $('#jam_mulai').text('Loading...');
                    $('#nama_lelang').text('Loading...');
                    $('#jam_selesai').text('Loading...');
                    $('#tanggal').text('Loading...');
                    $('#total_peserta').text('Loading...');
                    $('#lokasi').text('Loading...');
                    $('#total_produk').text('Loading...');
                    $('#ketua_lelang').text('Loading...');
                    $('#status').text('Loading...');
                    $('#total_penjualan_lelang').text('Loading...');
                    $('tbody#peserta_event').append('<tr><td colspan="2">Loading...</td></tr>')
                    $('tbody#penjual_event').append('<tr><td colspan="3">Loading...</td></tr>')
                    $('tbody#produk_lelang').append('<tr><td colspan="7">Loading...</td></tr>')
                },
                success: function(res) {
                    if(res.status == 'success') {
                        $('#event_kode').text(res.data.deskripsi.event_kode);
                        $('#jam_mulai').text(res.data.deskripsi.jam_mulai);
                        $('#nama_lelang').text(res.data.deskripsi.nama_lelang);
                        $('#jam_selesai').text(res.data.deskripsi.jam_selesai);
                        $('#tanggal').text(res.data.deskripsi.tanggal_lelang);
                        $('#total_peserta').text(res.data.deskripsi.total_peserta);
                        $('#lokasi').text(res.data.deskripsi.lokasi);
                        $('#total_produk').text(res.data.deskripsi.total_produk);
                        $('#ketua_lelang').text(res.data.deskripsi.ketua_lelang);
                        $('#status').text(res.data.deskripsi.status);
                        $('#total_penjualan_lelang').text(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.deskripsi.total_penjualan));
                        $('tbody#peserta_event').children().remove();
                        $('tbody#penjual_event').children().remove();
                        $('tbody#produk_lelang').children().remove();

                        let peserta = '';
                        for(let i = 0; i < res.data.peserta.length; i++) {
                            peserta += '<tr><td>'+ res.data.peserta[i].kode_peserta_lelang +'</td><td>'+ res.data.peserta[i].nama +'</td></tr>';
                        }
                        $('tbody#peserta_event').append(peserta);

                        peserta = '';
                        for(let i = 0; i < res.data.penjual.length; i++) {
                            peserta += '<tr><td>'+ (i + 1) +'</td><td>'+ res.data.penjual[i].nama_penjual +'</td><td>'+ res.data.penjual[i].komoditas +'</td></tr>';
                        }
                        $('tbody#penjual_event').append(peserta);

                        peserta = '';
                        for(let i = 0; i < res.data.produk.length; i++) {
                            peserta += '<tr><td>'+ res.data.produk[i].nomor_lelang +'</td><td>'+ res.data.produk[i].komoditas +'</td><td>'+ res.data.produk[i].judul +'</td><td>'+ Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.produk[i].harga_awal) +'</td><td>'+ Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.produk[i].kelipatan) +'</td><td>'+ Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(res.data.produk[i].harga_pemenang) +'</td><td>'+ res.data.produk[i].status +'</td></tr>';
                        }
                        $('tbody#produk_lelang').append(peserta);


                    } else {
                        $('#event_kode').text('Terjadi Kesalahan...');
                        $('#jam_mulai').text('Terjadi Kesalahan...');
                        $('#nama_lelang').text('Terjadi Kesalahan...');
                        $('#jam_selesai').text('Terjadi Kesalahan...');
                        $('#tanggal').text('Terjadi Kesalahan...');
                        $('#total_peserta').text('Terjadi Kesalahan...');
                        $('#lokasi').text('Terjadi Kesalahan...');
                        $('#total_produk').text('Terjadi Kesalahan...');
                        $('#ketua_lelang').text('Terjadi Kesalahan...');
                        $('#status').text('Terjadi Kesalahan...');
                        $('#total_penjualan_lelang').text('Terjadi Kesalahan...');
                        $('tbody#peserta_event').children().remove().append('<tr><td colspan="2">Terjadi Kesalahan...</td></tr>')
                        $('tbody#penjual_event').children().remove().append('<tr><td colspan="3">Terjadi Kesalahan...</td></tr>')
                        $('tbody#produk_lelang').children().remove().append('<tr><td colspan="7">Terjadi Kesalahan...</td></tr>')
                    }
                },
                error: function(err) {
                    console.error(err);
                        $('#event_kode').text('Error...');
                        $('#jam_mulai').text('Error...');
                        $('#nama_lelang').text('Error...');
                        $('#jam_selesai').text('Error...');
                        $('#tanggal').text('Error...');
                        $('#total_peserta').text('Error...');
                        $('#lokasi').text('Error...');
                        $('#total_produk').text('Error...');
                        $('#ketua_lelang').text('Error...');
                        $('#status').text('Error...');
                        $('#total_penjualan_lelang').text('Error...');
                        $('tbody#peserta_event').children().remove().append('<tr><td colspan="2">Error...</td></tr>')
                        $('tbody#penjual_event').children().remove().append('<tr><td colspan="3">Error...</td></tr>')
                        $('tbody#produk_lelang').children().remove().append('<tr><td colspan="7">Error...</td></tr>')
                }
            });
        })
    }
    if (routeName == 'jabatan.index') {
        $('.table-jabatan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'jabatan_id', name: 'jabatan_id'},
                {data: 'nama_jabatan', name: 'nama_jabatan'},
                {data: 'nama_level', name: 'nama_level'},
                {data: 'keterangan', name: 'keterangan'},
                {data: 'is_aktif', name: 'is_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'home.profil.area.create' || routeName == 'home.profil.area.edit') {
        $('select#provinsi_id').on('change', function(e) {
            if(e.target.value == 0 || e.target.value == '0') {
                $('select#kabupaten_id').attr('disabled', '').children().remove();
                $('select#kecamatan_id').attr('disabled', '').children().remove();
                $('select#desa_id').attr('disabled', '').children().remove();
            } else {
                $.ajax({
                    url: document.location.origin + '/profil/area/create/api',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        _token: csrf,
                        jenis: 'get-kabupaten',
                        provinsi_id: e.target.value
                    },
                    beforeSend: function() {
                        $('select#kabupaten_id').children().remove();
                        $('select#kabupaten_id').removeAttr('disabled').append('<option value="0">Loading</option>');
                    },
                    success: function(res) {
                        if(res.data.kabupaten.length > 0) {
                            $('select#kabupaten_id').removeAttr('disabled').children().remove();
                            $('select#kabupaten_id').append('<option value="0">Pilih Kabupaten</option>');
                            res.data.kabupaten.forEach(e => {
                                $('select#kabupaten_id').append('<option value="'+ e.kabupaten_id +'">'+ e.nama_kabupaten +'</option>');
                            });
                        } else {
                            $('select#kabupaten_id').attr('disabled', '').children().remove();
                            $('select#kabupaten_id').append('<option value="0">Tidak Ada Kabupaten</option>');
                        }
                    },
                    error: function(err) {
                        $('select#kabupaten_id').children().remove();
                        $('select#kabupaten_id').removeAttr('disabled').append('<option value="0">Error</option>');
                        console.error(err);
                    }
                });
            }
        });

        $('select#kabupaten_id').on('change', function(e) {
            if(e.target.value == 0 || e.target.value == '0') {
                $('select#kecamatan_id').attr('disabled', '').children().remove();
                $('select#desa_id').attr('disabled', '').children().remove();
            } else {
                $.ajax({
                    url: document.location.origin + '/profil/area/create/api',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        _token: csrf,
                        jenis: 'get-kecamatan',
                        kabupaten_id: e.target.value
                    },
                    beforeSend: function() {
                        $('select#kecamatan_id').children().remove();
                        $('select#kecamatan_id').removeAttr('disabled').append('<option value="0">Loading</option>');
                    },
                    success: function(res) {
                        if(res.data.kecamatan.length > 0) {
                            $('select#kecamatan_id').removeAttr('disabled').children().remove();
                            $('select#kecamatan_id').append('<option value="0">Pilih Kecamatan</option>');
                            res.data.kecamatan.forEach(e => {
                                $('select#kecamatan_id').append('<option value="'+ e.kecamatan_id +'">'+ e.nama_kecamatan +'</option>');
                            });
                        } else {
                            $('select#kecamatan_id').attr('disabled', '').children().remove();
                            $('select#kecamatan_id').append('<option value="0">Tidak Ada Kecamatan</option>');
                        }
                    },
                    error: function(err) {
                        $('select#kecamatan_id').children().remove();
                        $('select#kecamatan_id').removeAttr('disabled').append('<option value="0">Error</option>');
                        console.error(err);
                    }
                });
            }
        });

        $('select#kecamatan_id').on('change', function(e) {
            if(e.target.value == 0 || e.target.value == '0') {
                $('select#desa_id').attr('disabled', '').children().remove();
            } else {
                $.ajax({
                    url: document.location.origin + '/profil/area/create/api',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        _token: csrf,
                        jenis: 'get-desa',
                        kecamatan_id: e.target.value
                    },
                    beforeSend: function() {
                        $('select#desa_id').children().remove();
                        $('select#desa_id').removeAttr('disabled').append('<option value="0">Loading</option>');
                    },
                    success: function(res) {
                        if(res.data.desa.length > 0) {
                            $('select#desa_id').removeAttr('disabled').children().remove();
                            $('select#desa_id').append('<option value="0">Pilih Desa</option>');
                            res.data.desa.forEach(e => {
                                $('select#desa_id').append('<option value="'+ e.desa_id +'">'+ e.nama_desa +'</option>');
                            });
                        } else {
                            $('select#desa_id').attr('disabled', '').children().remove();
                            $('select#desa_id').append('<option value="0">Tidak Ada Desa</option>');
                        }
                    },
                    error: function(err) {
                        $('select#desa_id').children().remove();
                        $('select#desa_id').removeAttr('disabled').append('<option value="0">Error</option>');
                        console.error(err);
                    }
                });
            }
        });
    }
    if(routeName == 'home.profil.area') {
        $('.table-area-profile').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'area_member_id', name: 'area_member_id'},
                {data: 'nama_provinsi', name: 'nama_provinsi'},
                {data: 'nama_kabupaten', name: 'nama_kabupaten'},
                {data: 'nama_kecamatan', name: 'nama_kecamatan'},
                {data: 'nama_desa', name: 'nama_desa'},
                {data: 'alamat', name: 'alamat'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'home.profil.dokumen') {
        $('.table-dokumen-profil').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'jenis_dokumen', name: 'jenis_dokumen'},
                {data: 'tanggal_unggah', name: 'tanggal_unggah'},
                {data: 'nama_dokumen', name: 'nama_dokumen'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'home.profil.password') {
        $('.password').on('click', function (e) {
            if($(this).parent().siblings().attr('type') == 'password'){
                $(this).parent().siblings().attr('type', 'text');
            } else {
                $(this).parent().siblings().attr('type', 'password');
            }
        });
    }
    if(routeName == 'home.profil.rekening_bank.create' || routeName == 'home.profil.rekening_bank.edit') {
        $("select#bank_id").select2({
            tags: true
        });
        $("select#mata_uang").select2({
            tags: true
        });
    }
    if(routeName == 'home.profil.rekening_bank') {
        $('.table-rekening-bank-profil').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'bank', name: 'bank'},
                {data: 'nomor_rekening', name: 'nomor_rekening'},
                {data: 'saldo', name: 'saldo'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'home.saldo.riwayat') {
        $('.table-riwayat-saldo').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'tanggal', name: 'tanggal'},
                {data: 'rekening_bank', name: 'rekening_bank'},
                {data: 'jenis_transaksi', name: 'jenis_transaksi'},
                {data: 'jumlah', name: 'jumlah'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'home.saldo.jaminan') {
        $('.table-jaminan').DataTable();
    }
    if(routeName == 'home.saldo.jaminan.riwayat') {
        $('.table-riwayat-jaminan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'tanggal', name: 'tanggal'},
                {data: 'jenis', name: 'jenis'},
                {data: 'jumlah', name: 'jumlah'},
                {data: 'status', name: 'status'},
            ]
        });
    }
    if(routeName == 'master.anggota.kpb') {
        $('.table-anggota-kpb').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'nik', name: 'nik'},
                {data: 'nama', name: 'nama'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.anggota.calon') {
        $('.table-calon-anggota').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'informasi_akun_id', name: 'informasi_akun_id'},
                {data: 'nama', name: 'nama'},
                {data: 'no_hp', name: 'no_hp'},
                {data: 'email', name: 'email'},
                {data: 'jenis_member', name: 'jenis_member'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.anggota.verifikasi') {
        $('.table-calon-anggota').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'informasi_akun_id', name: 'informasi_akun_id'},
                {data: 'nama', name: 'nama'},
                {data: 'no_hp', name: 'no_hp'},
                {data: 'email', name: 'email'},
                {data: 'jenis_member', name: 'jenis_member'},
                {data: 'created_at', name: 'created_at'},
                {data: 'regist_oleh', name: 'regist_oleh'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.anggota.list.area.create' || routeName == 'master.anggota.list.area.edit') {
        $('select#provinsi_lembaga').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/kabupaten/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#kabupaten_lembaga').attr('disabled', '').children().remove();
                        $('select#kecamatan_lembaga').attr('disabled', '').children().remove();
                        $('select#desa_lembaga').attr('disabled', '').children().remove();
                    }
                    $('select#kabupaten_lembaga').removeAttr('disabled').append(`<option value="0">Pilih Kabupaten</option>`)
                    res.data.forEach(d =>
                        $('select#kabupaten_lembaga').append(`<option value="${d.kabupaten_id}">${d.nama_kabupaten}</option>`)
                    )
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kabupaten: " + err)
                }
            })
        })

        $('select#kabupaten_lembaga').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/kecamatan/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#kecamatan_lembaga').attr('disabled', '').children().remove();
                        $('select#desa_lembaga').attr('disabled', '').children().remove();
                    }
                    $('select#kecamatan_lembaga').removeAttr('disabled').append(`<option value="0">Pilih Kecamatan</option>`)
                    res.data.forEach(d =>
                        $('select#kecamatan_lembaga').append(`<option value="${d.kecamatan_id}">${d.nama_kecamatan}</option>`)
                    )
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kecamatan: " + err)
                }
            })
        })

        $('select#kecamatan_lembaga').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/desa/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#desa_lembaga').attr('disabled', '').children().remove();
                    }
                    $('select#desa_lembaga').removeAttr('disabled').append(`<option value="0">Pilih Desa</option>`)
                    res.data.forEach(d =>
                        $('select#desa_lembaga').append(`<option value="${d.desa_id}">${d.nama_desa}</option>`)
                    )
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kecamatan: " + err)
                }
            })
        })

        $('select#provinsi').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/kabupaten/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#kabupaten').attr('disabled', '').children().remove();
                        $('select#kecamatan').attr('disabled', '').children().remove();
                        $('select#desa').attr('disabled', '').children().remove();
                    }
                    $('select#kabupaten').removeAttr('disabled').append(`<option value="0">Pilih Kabupaten</option>`)
                    res.data.forEach(d =>
                        $('select#kabupaten').append(`<option value="${d.kabupaten_id}">${d.nama_kabupaten}</option>`)
                    )
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kabupaten: " + err)
                }
            })
        })

        $('select#kabupaten').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/kecamatan/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#kecamatan').attr('disabled', '').children().remove();
                        $('select#desa').attr('disabled', '').children().remove();
                    }
                    $('select#kecamatan').removeAttr('disabled').append(`<option value="0">Pilih Kecamatan</option>`)
                    res.data.forEach(d =>
                        $('select#kecamatan').append(`<option value="${d.kecamatan_id}">${d.nama_kecamatan}</option>`)
                    )
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kecamatan: " + err)
                }
            })
        })

        $('select#kecamatan').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/desa/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#desa').attr('disabled', '').children().remove();
                    }
                    $('select#desa').removeAttr('disabled').append(`<option value="0">Pilih Desa</option>`)
                    res.data.forEach(d =>
                        $('select#desa').append(`<option value="${d.desa_id}">${d.nama_desa}</option>`)
                    )
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kecamatan: " + err)
                }
            });
        });
    }
    if(routeName == 'master.anggota.list.area.index') {
        $('.table-area-member').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'area_member_id', name: 'area_member_id'},
                {data: 'provinsi', name: 'provinsi'},
                {data: 'kabupaten', name: 'kabupaten'},
                {data: 'kecamatan', name: 'kecamatan'},
                {data: 'desa', name: 'desa'},
                {data: 'alamat', name: 'alamat'},
                {data: 'kode_pos', name: 'kode_pos'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.anggota.list.dokumen.index') {
        $('.table-dokumen').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'dokumen_member_id', name: 'dokumen_member_id'},
                {data: 'jenis_dokumen', name: 'jenis_dokumen'},
                {data: 'nama_file', name: 'nama_file'},
                {data: 'tanggal_unggah', name: 'tanggal_unggah'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.anggota.list.rekening.index') {
        $('.table-rekening').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'rekening_bank_id', name: 'rekening_bank_id'},
                {data: 'nama_bank', name: 'nama_bank'},
                {data: 'nomor_rekening', name: 'nomor_rekening'},
                {data: 'nama_pemilik', name: 'nama_pemilik'},
                {data: 'cabang', name: 'cabang'},
                {data: 'mata_uang', name: 'mata_uang'},
                {data: 'saldo', name: 'saldo'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.lain.rekening') {
        $('.table-rekening-admin').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'rekening_bank_id', name: 'rekening_bank_id'},
                {data: 'nama_bank', name: 'nama_bank'},
                {data: 'nomor_rekening', name: 'nomor_rekening'},
                {data: 'nama_pemilik', name: 'nama_pemilik'},
                {data: 'cabang', name: 'cabang'},
                {data: 'mata_uang', name: 'mata_uang'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.lain.komoditas.create' || routeName == "master.lain.komoditas.edit") {
        $("select#jenis_komoditas_id").select2({
            tags: true
        });
    }
    if(routeName == 'master.lain.komoditas') {
        $('.table-komoditas').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'komoditas_id', name: 'komoditas_id'},
                {data: 'nama_komoditas', name: 'nama_komoditas'},
                {data: 'satuan_ukuran', name: 'satuan_ukuran'},
                {data: 'inisiasi', name: 'inisiasi'},
                {data: 'kadaluarsa', name: 'kadaluarsa'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.lain.dokumen_persyaratan') {
        $('.table-dokumen_persyaratan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'jenis_dokumen_id', name: 'jenis_dokumen_id'},
                {data: 'nama_jenis', name: 'nama_jenis'},
                {data: 'keterangan', name: 'keterangan'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.anggota.dibekukan') {
        $('.table-dibekukan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'informasi_akun_id', name: 'informasi_akun_id'},
                {data: 'suspend_kode', name: 'suspend_kode'},
                {data: 'nama', name: 'name'},
                {data: 'username', name: 'username'},
                {data: 'jenis_anggota', name: 'jenis_anggota'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.anggota.list') {
        $('.table-list-anggota').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'informasi_akun_id', name: 'informasi_akun_id'},
                {data: 'nama', name: 'nama'},
                {data: 'no_hp', name: 'no_hp'},
                {data: 'email', name: 'email'},
                {data: 'jenis_member', name: 'jenis_member'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.lembaga.bank') {
        $('.table-lembaga-bank').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'bank_id', name: 'bank_id'},
                {data: 'kode_bank', name: 'kode_bank'},
                {data: 'nama_bank', name: 'nama_bank'},
                {data: 'count', name: 'count'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'transaksi.lelang_baru.create' || routeName == 'transaksi.lelang_baru.edit' || routeName == 'transaksi.lelang_list.edit') {
        let dataKontrak = [];
        $("select#jenis_perdagangan_id").select2({
            tags: true
        });
        $("select#informasi_akun_id").select2({
            tags: true
        });
        $("select#komoditas_id").select2({
            tags: true
        });
        $("select#jenis_inisiasi_id").select2({
            tags: true
        });
        $("select#informasi_akun_id").on('change', function(e) {
            $.ajax({
                url: document.location.origin + '/transaksi/lelang_baru/option',
                data: {
                    jenis: 'informasi_akun',
                    informasi_akun_id: e.target.value,
                },
                dataType: 'json',
                method: 'get',
                success: function(data) {
                    if(data.data.length > 0) {
                        dataKontrak = data.data;
                        $('select#kontrak_id').removeAttr('disabled').children().remove();
                        let i =0;
                        for(i = 0; i < data.data.length; i++) {
                            $('select#kontrak_id').append(`<option data-satuan_ukur="${data.data[i].satuan_ukuran}" value="${data.data[i].kontrak_id}">${data.data[i].kontrak_kode}</option>`);
                        }
                        $('#kode_komoditas').text(data.data[0].komoditas_id);
                        $('#isi_komoditas').text(data.data[0].nama_komoditas);
                        $('#isi_satuan_transaksi').text(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(data.data[0].minimum_transaksi));
                        $('#isi_jenis_perdagangan').text(data.data[0].nama_perdagangan);
                        $('#isi_max_transaksi').text(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(data.data[0].maksimum_transaksi));
                        $('#isi_mutu').text(data.data[0].nama_mutu);
                        $('#isi_uom').text(data.data[0].satuan_ukuran);
                        $(".no-kontrak").addClass('d-none');
                        $(".table-rincian-kontrak").removeClass('d-none');
                        setSatuanUkuran(data.data[0].kontrak_id)
                    } else {
                        $("select#kontrak_id").attr('disabled', '')
                        $("select#kontrak_id").children().remove();
                        $(".no-kontrak").removeClass('d-none').text('Tidak ada kontrak yang tertaut ke akun ini');
                        $(".table-rincian-kontrak").addClass('d-none');
                    }
                }, error: function(err) {
                    $(".no-kontrak").removeClass('d-none').text('Terjadi Error, Periksa koneksi internet anda');
                    $(".table-rincian-kontrak").addClass('d-none');
                }
            })
        });
        $('select#kontrak_id').on('change', function(e) {
            setSatuanUkuran(e.target.value);
            let temp = null;
            if(routeName == 'transaksi.lelang_baru.create') {
                temp = dataKontrak.find(x => x.kontrak_id === e.target.value)

                $('#kode_komoditas').text(temp.komoditas_id);
                $('#isi_komoditas').text(temp.nama_komoditas);
                $('#isi_satuan_transaksi').text(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(temp.minimum_transaksi));
                $('#isi_jenis_perdagangan').text(temp.nama_perdagangan);
                $('#isi_max_transaksi').text(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(temp.maksimum_transaksi));
                $('#isi_mutu').text(temp.nama_mutu);
                $('#isi_uom').text(temp.satuan_ukuran);
                $(".no-kontrak").addClass('d-none');
                $(".table-rincian-kontrak").removeClass('d-none');
            } else {
                $.ajax({
                    url: document.location.origin + '/transaksi/lelang_baru/option',
                    data: {
                        jenis: 'kontrak_detail_komoditas',
                        kontrak_id: e.target.value,
                    },
                    dataType: 'json',
                    method: 'get',
                    success: function(data) {
                        $('#kode_komoditas').text(data.data.komoditas_id);
                        $('#isi_komoditas').text(data.data.nama_komoditas);
                        $('#isi_satuan_transaksi').text(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(data.data.minimum_transaksi));
                        $('#isi_jenis_perdagangan').text(data.data.nama_perdagangan);
                        $('#isi_max_transaksi').text(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(data.data.maksimum_transaksi));
                        $('#isi_mutu').text(data.data.nama_mutu);
                        $('#isi_uom').text(data.data.satuan_ukuran);
                        $(".no-kontrak").addClass('d-none');
                        $(".table-rincian-kontrak").removeClass('d-none');
                    },
                    error: function(err) {return err;}
                });
            }
        });
        function setSatuanUkuran(initial) {
            let temp, i = 0;
            for( i = 0; i < $('select#kontrak_id').children().length; i++) {
                if($('select#kontrak_id').children()[i].value === initial) {
                    temp = $('select#kontrak_id').children()[i];
                }
            }
            $('span.kuantitas').removeClass('d-none').html(temp.attributes[0].value)
        }
        $('#harga_beli_sekarang').on('change', function(e) {
            if(e.currentTarget.checked) {
                $('.harga_beli_sekarang_wrapper').removeClass('d-none');
            } else {
                $('.harga_beli_sekarang_wrapper').addClass('d-none');
            }
        })
        $('input[name=jenis_harga_id]').on('change', function(e) {
            console.log('ok')
            if(e.target.value === penawaranPadaHargaSatuan) {
                $('.harga_satuan').removeClass('d-none');
            } else {
                $('.harga_satuan').addClass('d-none');
            }
        })
    }
    if(routeName == 'transaksi.lelang_baru.file' || routeName == 'transaksi.lelang_list.file') {
        $('.table-lelang-file').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'dokumen_produk_id', name: 'dokumen_produk_id'},
                {data: 'jenis_dokumen', name: 'jenis_dokumen'},
                {data: 'gambar', name: 'gambar'},
                {data: 'nama_dokumen', name: 'nama_dokumen'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'offline.profile') {
        $('.table-lelang-profile').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'registrasi_id', name: 'registrasi_id'},
                {data: 'nama_lengkap', name: 'nama_lengkap'},
                {data: 'is_open', name: 'is_open'},
                {data: 'tanggal_register', name: 'tanggal_register'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'offline.operator.create' || routeName == 'offline.operator.edit') {
        $('#button-check').on('click', function(e) {
            if($(this).siblings('input').attr('type') == 'text') {
                $(this).siblings('input').attr('type', 'password');
                $(this).children().children().addClass('fa-eye').removeClass('fa-eye-slash')
            } else {
                $(this).siblings('input').attr('type', 'text');
                $(this).children().children().removeClass('fa-eye').addClass('fa-eye-slash')
            }
        })
    }
    if(routeName == 'offline.operator') {
        $('.table-lelang-operator').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'user_id', name: 'user_id'},
                {data: 'nama_lengkap', name: 'nama_lengkap'},
                {data: 'is_aktif', name: 'is_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'offline.event.anggota' || routeName == 'online.event.anggota') {
        $('.table-lelang-event-anggota').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'kode_peserta_lelang', name: 'kode_peserta_lelang'},
                {data: 'username', name: 'username'},
                {data: 'nama', name: 'nama'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'offline.event.anggota.create') {
        $("select#informasi_akun_id").select2({
            tags: true
        });
    }
    if(routeName == 'online.event.anggota.create') {
        $("select#informasi_akun_id").select2({
            tags: true
        });
    }
    if(routeName == 'transaksi.lelang_list') {
        $('.table-lelang-list').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'tanggal', name: 'tanggal'},
                {data: 'jam', name: 'jam'},
                {data: 'nama', name: 'nama'},
                {data: 'kontrak', name: 'kontrak'},
                {data: 'nomor_lelang', name: 'nomor_lelang'},
                {data: 'judul', name: 'judul'},
                {data: 'harga_awal', name: 'harga_awal'},
                {data: 'status', name: 'status'},
                {data: 'jenis', name: 'jenis'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'transaksi.lelang_baru') {
        $('.table-lelang-baru').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'lelang_id', name: 'lelang_id'},
                {data: 'nama', name: 'nama'},
                {data: 'kontrak', name: 'kontrak'},
                {data: 'nomor_lelang', name: 'nomor_lelang'},
                {data: 'judul', name: 'judul'},
                {data: 'harga_awal', name: 'harga_awal'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'online.event' || routeName == 'online.event.history') {
        $('.table-lelang-event').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            dataType: 'json',
            data: {
                _token: csrf,
                x: 'ok'
            },
            ajax: document.location.href,
            columns: [
                {data: 'penyelenggara', name: 'penyelenggara'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'sesi', name: 'sesi'},
                {data: 'judul', name: 'judul'},
                {data: 'harga_awal', name: 'harga_awal'},
                {data: 'kelipatan_harga', name: 'kelipatan_harga'},
                {data: 'total', name: 'total'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'offline.event' || routeName == 'offline.event.history') {
        $('.table-lelang-event').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'event_kode', name: 'event_kode'},
                {data: 'nama_lelang', name: 'nama_lelang'},
                {data: 'tanggal_lelang', name: 'tanggal_lelang'},
                {data: 'jam_lelang', name: 'jam_lelang'},
                {data: 'lokasi', name: 'lokasi'},
                {data: 'penyelenggaraan', name: 'penyelenggaraan'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'transaksi.verifikasi_lelang.show') {
        $('input[name=jenis_penyelenggaraan]').on('change', function(e) {
            if(e.target.value == 'online'){
                $('.sesi-online').removeClass('d-none');
                $('.sesi-hybrid').addClass('d-none');
                $('.sesi-offline').addClass('d-none');
            }
            if(e.target.value == 'offline'){
                $('.sesi-online').addClass('d-none');
                $('.sesi-hybrid').addClass('d-none');
                $('.sesi-offline').removeClass('d-none');
            }
            if(e.target.value == 'hybrid'){
                $('.sesi-online').addClass('d-none');
                $('.sesi-offline').addClass('d-none');
                $('.sesi-hybrid').removeClass('d-none');
            }
        });

        $('input[name=konfirmasi]').on('change', function(e) {
            if(e.target.value == 'true') {
                $('.jenis-penyelenggaraan').removeClass('d-none');
            } else {
                $('.jenis-penyelenggaraan').addClass('d-none');
                $('.sesi-online').addClass('d-none');
                $('.sesi-offline').addClass('d-none');
                $('.sesi-hybrid').addClass('d-none');
            }
        })
    }
    if(routeName == 'transaksi.verifikasi_lelang') {
        $('.table-verifikasi-lelang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'lelang_id', name: 'lelang_id'},
                {data: 'nama', name: 'nama'},
                {data: 'kontrak', name: 'kontrak'},
                {data: 'nomor_lelang', name: 'nomor_lelang'},
                {data: 'judul', name: 'judul'},
                {data: 'harga_awal', name: 'harga_awal'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'transaksi.verifikasi_lelang.ditolak') {
        $('.table-verifikasi-lelang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'lelang_id', name: 'lelang_id'},
                {data: 'nama', name: 'nama'},
                {data: 'kontrak', name: 'kontrak'},
                {data: 'nomor_lelang', name: 'nomor_lelang'},
                {data: 'judul', name: 'judul'},
                {data: 'harga_awal', name: 'harga_awal'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.lembaga.gudang') {
        $('.table-lembaga-gudang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'gudang_id', name: 'gudang_id'},
                {data: 'penyelenggara_pasar_lelang', name: 'penyelenggara_pasar_lelang'},
                {data: 'gudang_kode', name: 'gudang_kode'},
                {data: 'nama_gudang', name: 'nama_gudang'},
                {data: 'alamat', name: 'alamat'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.kontrak.pengaturan' || routeName == 'master.kontrak.verifikasi.riwayat' || routeName == 'master.kontrak.list' || routeName == 'master.kontrak.nonaktif') {
        $('.table-pengaturan-kontrak').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'kontrak_id', name: 'kontrak_id'},
                {data: 'komoditas', name: 'nama'},
                {data: 'jenis_perdagangan', name: 'jenis_perdagangan'},
                {data: 'username', name: 'username'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'lelang.pengajuan.file') {
        $('.table-lelang-dokumen-user').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'dokumen_produk_id', name: 'dokumen_produk_id'},
                {data: 'jenis_dokumen', name: 'jenis_dokumen'},
                {data: 'gambar', name: 'gambar'},
                {data: 'nama_dokumen', name: 'nama_dokumen'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'online.list.lelang_sesi') {
        $('.bid_btn').on('click', function () {
            if(isNaN(parseInt($('#kode_peserta').text()))) {
                window.alert('Anda harus bergabung ke sesi lelang ini.');
            } else {
                $.ajax({
                    url: document.location.pathname + '/api',
                    data: {
                        'peserta': isNaN(parseInt($('#kode_peserta').text())) ? 0 : parseInt($('#kode_peserta').text()),
                        'harga': harga_awal,
                        'waktu': count,
                        'code': 'penawaran',
                        '_token': csrf
                    },
                    dataType: 'json',
                    method: 'post',
                    success: function(res) {
                        if(res.status == 'failed') {
                            window.alert(res.message)
                        }
                    },
                    error: function(err) {console.error(err)},
                });
            }
        });

        let kelipatan_harga = parseInt($('#kelipatan_harga').text().replaceAll(',', ''));
        $(function() {
            setInterval(function() {
                $.ajax({
                    url: document.location.pathname + '/api',
                    data:{
                        'code': 'getAnyRequest',
                        '_token': csrf,
                        'peserta': 0
                    },
                    dataType: 'json',
                    method: 'post',
                    success: function(res) {

                        if(res.data.done) {
                            // Selesai
                            $('.bid_btn').addClass('d-none').removeClass('d-block');
                            $('.waiting_btn').addClass('d-none').removeClass('d-block');
                            $('.closed_btn').removeClass('d-none').addClass('d-block');
                        } else {
                            if(!res.data.aktif) {
                                // Belum Mulai
                                $('.closed_btn').addClass('d-none').removeClass('d-block');
                                $('.bid_btn').addClass('d-none').removeClass('d-block');
                                $('.waiting_btn').removeClass('d-none').addClass('d-block');
                            } else {
                                // Aktif
                                $('.waiting_btn').addClass('d-none').removeClass('d-block');
                                $('.closed_btn').addClass('d-none').removeClass('d-block');
                                $('.bid_btn').removeClass('d-none').addClass('d-block');
                            }
                        }

                        var hours = ("0" + Math.floor(res.data.count / 3600)).slice(-2);
                        var minutes = ("0" + Math.floor((res.data.count - (hours * 3600)) / 60)).slice(-2);
                        var seconds = ("0" + (res.data.count - (hours * 3600) - (minutes * 60))).slice(-2);
                        document.getElementById("time").innerHTML = hours + ":" + minutes + ":" + seconds;

                        if(res.data.riwayat.length > 0) {
                            if(res.data.aktif) {
                                $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data.riwayat[res.data.riwayat.length - 1].harga_ajuan.split('.')[0]) + parseInt(kelipatan_harga))).replaceAll('.', ','));
                            } else {
                                $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data.riwayat[res.data.riwayat.length - 1].harga_ajuan.split('.')[0]))).replaceAll('.', ','));
                            }

                            $('.riwayat_penawaran').children().remove();
                            res.data.riwayat.forEach(x => {
                                var hours = ("0" + Math.floor(x.waktu / 3600)).slice(-2);
                                var minutes = ("0" + Math.floor((x.waktu - (hours * 3600)) / 60)).slice(-2);
                                var seconds = ("0" + (x.waktu - (hours * 3600) - (minutes * 60))).slice(-2);

                                    if($('div.riwayat_penawaran').children('p').length == 1) {
                                        $('.riwayat_penawaran').children('p').remove();
                                        $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                    } else {
                                        if($('div.riwayat_penawaran').children('ul').length == 0) {
                                            $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                        } else {
                                            $('.riwayat_penawaran').children('ul.list-group').prepend('<li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li>');
                                        }
                                    }
                            });
                        }
                    }, error: function(err) {
                        console.error(err);
                    }
                });
            }, 1000);
        });
    }
    if(routeName == 'online.event.sesi') {
        // Admin
        let kelipatan_harga = parseInt($('#kelipatan_harga').text().replace(',', ''));
        $(function() {
            setInterval(function() {
                $.ajax({
                    url: document.location.pathname + '/api',
                    data:{
                        'code': 'getAnyRequest',
                        '_token': csrf,
                        'peserta': 0
                    },
                    dataType: 'json',
                    method: 'post',
                    success: function(res) {
                        if(res.data.done) {
                            // Selesai
                            $('.bid_btn').addClass('d-none').removeClass('d-block');
                            $('.waiting_btn').addClass('d-none').removeClass('d-block');
                            $('.closed_btn').removeClass('d-none').addClass('d-block');
                        } else {
                            if(!res.data.aktif) {
                                // Belum Mulai
                                $('.closed_btn').addClass('d-none').removeClass('d-block');
                                $('.bid_btn').addClass('d-none').removeClass('d-block');
                                $('.waiting_btn').removeClass('d-none').addClass('d-block');
                            } else {
                                // Aktif
                                $('.waiting_btn').addClass('d-none').removeClass('d-block');
                                $('.closed_btn').addClass('d-none').removeClass('d-block');
                                $('.bid_btn').removeClass('d-none').addClass('d-block');
                            }
                        }

                        var hours = ("0" + Math.floor(res.data.count / 3600)).slice(-2);
                        var minutes = ("0" + Math.floor((res.data.count - (hours * 3600)) / 60)).slice(-2);
                        var seconds = ("0" + (res.data.count - (hours * 3600) - (minutes * 60))).slice(-2);
                        document.getElementById("time").innerHTML = hours + ":" + minutes + ":" + seconds;

                        if(res.data.riwayat.length > 0) {
                            if(res.data.aktif) {
                                $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data.riwayat[res.data.riwayat.length - 1].harga_ajuan.split('.')[0]) + parseInt(kelipatan_harga))).replaceAll('.', ','));
                            } else {
                                $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data.riwayat[res.data.riwayat.length - 1].harga_ajuan.split('.')[0]))).replaceAll('.', ','));
                            }

                            $('.riwayat_penawaran').children().remove();
                            res.data.riwayat.forEach(x => {
                                var hours = ("0" + Math.floor(x.waktu / 3600)).slice(-2);
                                var minutes = ("0" + Math.floor((x.waktu - (hours * 3600)) / 60)).slice(-2);
                                var seconds = ("0" + (x.waktu - (hours * 3600) - (minutes * 60))).slice(-2);

                                    if($('div.riwayat_penawaran').children('p').length == 1) {
                                        $('.riwayat_penawaran').children('p').remove();
                                        $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                    } else {
                                        if($('div.riwayat_penawaran').children('ul').length == 0) {
                                            $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                        } else {
                                            $('.riwayat_penawaran').children('ul.list-group').prepend('<li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li>');
                                        }
                                    }
                            });
                        }
                    }, error: function(err) {
                        console.error(err);
                    }
                });
            }, 1000);
        });
    }
    if(routeName == 'master.kontrak.verifikasi') {
        $('.table-pengaturan-kontrak').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'kontrak_id', name: 'kontrak_id'},
                {data: 'nama_member', name: 'nama_member'},
                {data: 'komoditas', name: 'nama'},
                {data: 'jenis_perdagangan', name: 'jenis_perdagangan'},
                {data: 'username', name: 'username'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.lembaga.gudang.create' || routeName == 'master.lembaga.gudang.edit') {
        $("select#penyelenggara_pasar_lelang_id").select2({
            tags: true
        });
    }
    if(routeName == 'master.kontrak.pengaturan.create' || routeName == 'master.kontrak.pengaturan.edit' || routeName == 'master.kontrak.list.edit' || routeName == 'master.kontrak.list.edit') {
        $("select#komoditas_id").select2({
            tags: true
        });
        $("select#informasi_akun_id").select2({
            tags: true
        });
        $("select#jenis_perdagangan_id").select2({
            tags: true
        });
        $("select#penyelenggara_pasar_lelang_id").select2({
            tags: true
        });
        $("select#mutu_id").select2({
            tags: true
        });
    }
    if(routeName == 'kontrak.pengajuan.create' || routeName == 'kontrak.pengajuan.edit') {
        $("select#penyelenggara_pasar_lelang_id").select2({
            tags: true
        });
        $("select#jenis_perdagangan_id").select2({
            tags: true
        });
        $("select#komoditas_id").select2({
            tags: true
        });
        $("select#mutu_id").select2({
            tags: true
        });
    }
    if(routeName == 'kontrak.pengajuan' || routeName == 'kontrak.list') {
        $('.table-kontrak-user').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'penyelenggara', name: 'penyelenggara'},
                {data: 'komoditas', name: 'komoditas'},
                {data: 'jenis_perdagangan', name: 'jenis_perdagangan'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'lelang.transaksi') {
        $('.table-lelang-user').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'nomor_lelang', name: 'nomor_lelang'},
                {data: 'judul', name: 'judul'},
                {data: 'kuantitas', name: 'kuantitas'},
                {data: 'harga_awal', name: 'harga_awal'},
                {data: 'harga_pemenang', name: 'harga_pemenang'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'lelang.transaksi.show') {
        $('.rekening_bank_pembeli').on('change', function(e) {
            let hargaBayar = $('#total_yang_harus_dibayar').val().replaceAll(',', '', true);

            $.ajax({
                url: document.location.origin + '/profil/rekening_bank/' + e.target.value + '/get-saldo',
                method: 'get',
                data: {
                    _token: csrf,
                },
                dataType: 'json',
                success: function(res) {
                    if(res.data - hargaBayar >= 0) {
                        // Dana Cukup
                        $('.informasi-saldo').html('Saldo Anda: <span class="text-success">Rp. '+ Intl.NumberFormat().format(res.data) +'</span> Masih Ada Sisa Dana Sebesar <span class="text-primary">Rp. '+ Intl.NumberFormat().format(parseInt(res.data) - parseInt(hargaBayar)) +'</span>')
                    } else {
                        // Dana kurang
                        $('.informasi-saldo').html('Saldo Anda: <span class="text-success">Rp. '+ Intl.NumberFormat().format(res.data) +'</span> Terdapat Kekurangan dana sebesar: <span class="text-danger">Rp. '+ Intl.NumberFormat().format(parseInt(hargaBayar) - parseInt(res.data))  +'</span>')
                    }
                },
                error: function(err) {
                    console.error(err);
                }
            })
        })
    }
    if(routeName == 'lelang.pengajuan.create' || routeName == 'lelang.pengajuan.edit') {
        $("select#jenis_perdagangan_id").select2({
            tags: true
        });
        $("select#informasi_akun_id").select2({
            tags: true
        });
        $("select#komoditas_id").select2({
            tags: true
        });
        $("select#jenis_inisiasi_id").select2({
            tags: true
        });
        $('select#kontrak_id').on('change', function(e) {
            $.ajax({
                url: document.location.origin + '/transaksi/lelang_baru/option',
                data: {
                    jenis: 'kontrak_detail_komoditas',
                    kontrak_id: e.target.value,
                },
                dataType: 'json',
                method: 'get',
                success: function(data) {
                    $('#kode_komoditas').text(data.data.komoditas_id);
                    $('#isi_komoditas').text(data.data.nama_komoditas);
                    $('#isi_satuan_transaksi').text(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(data.data.minimum_transaksi));
                    $('#isi_jenis_perdagangan').text(data.data.nama_perdagangan);
                    $('#isi_max_transaksi').text(Intl.NumberFormat('id-ID', {style: 'currency' ,currency: 'IDR', }).format(data.data.maksimum_transaksi));
                    $('#isi_mutu').text(data.data.nama_mutu);
                    $('#isi_uom').text(data.data.satuan_ukuran);
                    $('span.kuantitas').removeClass('d-none').html(data.data.satuan_ukuran)
                    $(".no-kontrak").addClass('d-none');
                    $(".table-rincian-kontrak").removeClass('d-none');
                },
                error: function(err) {return err;}
            });
        });
        $('#harga_beli_sekarang').on('change', function(e) {
            if(e.currentTarget.checked) {
                $('.harga_beli_sekarang_wrapper').removeClass('d-none');
            } else {
                $('.harga_beli_sekarang_wrapper').addClass('d-none');
            }
        })
        $('input[name=jenis_harga_id]').on('change', function(e) {

            if(e.target.value === penawaranPadaHargaSatuan) {
                $('.harga_satuan').removeClass('d-none');
            } else {
                $('.harga_satuan').addClass('d-none');
            }
        })
    }
    if(routeName == 'lelang.pengajuan' || routeName == 'lelang.list') {
        $('.table-lelang-user').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'kontrak_kode', name: 'kontrak_kode'},
                {data: 'nomor_lelang', name: 'nomor_lelang'},
                {data: 'judul', name: 'judul'},
                {data: 'kuantitas', name: 'kuantitas'},
                {data: 'harga_awal', name: 'harga_awal'},
                {data: 'kelipatan_penawaran', name: 'kelipatan_penawaran'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'online.list' || routeName =='online.history') {
        $('.table-sesi-lelang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'tanggal', name: 'tanggal'},
                {data: 'sesi', name: 'sesi'},
                {data: 'produk', name: 'produk'},
                {data: 'anggota', name: 'anggota'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'online.list.show' || routeName == 'offline.list.show') {
        $('.table-sesi-lelang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'penjual', name: 'penjual'},
                {data: 'gambar', name: 'gambar'},
                {data: 'nama_produk', name: 'nama_produk'},
                {data: 'kuantitas', name: 'kuantitas'},
                {data: 'harga_awal', name: 'harga_awal'},
                {data: 'kelipatan', name: 'kelipatan'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'online.history.show') {
        $('.table-sesi-lelang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'penjual', name: 'penjual'},
                {data: 'gambar', name: 'gambar'},
                {data: 'nama_produk', name: 'nama_produk'},
                {data: 'kuantitas', name: 'kuantitas'},
                {data: 'kode_peserta', name: 'kode_peserta'},
                {data: 'harga_awal', name: 'harga_awal'},
                {data: 'kelipatan', name: 'kelipatan'},
                {data: 'harga_pemenang', name: 'harga_pemenang'},
            ]
        });
    }
    if(routeName == 'offline.list' || routeName =='offline.history') {
        $('.table-sesi-lelang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'nama', name: 'nama'},
                {data: 'event_kode', name: 'event_kode'},
                {data: 'nama_lelang', name: 'nama_lelang'},
                {data: 'tanggal_lelang', name: 'tanggal_lelang'},
                {data: 'jam', name: 'jam'},
                {data: 'jenis', name: 'jenis'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.anggota.calon.create' || routeName == 'master.anggota.calon.edit') {
        $('input[name=jenis_perseorangan]').on('change', function() {
            if($(this).val() == 'perseorangan') {
                $('.card.lembaga').addClass('d-none')
                $('.title-card-pic').text('Informasi Calon Anggota')
                $('.lembaga-mandatory').addClass('d-none');
            } else {
                $('.card.lembaga').removeClass('d-none')
                $('.title-card-pic').text('Informasi PIC Lembaga')
                $('.lembaga-mandatory').removeClass('d-none');
            }
        })

        $('select#provinsi_lembaga').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/kabupaten/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#kabupaten_lembaga').attr('disabled', '').children().remove();
                        $('select#kecamatan_lembaga').attr('disabled', '').children().remove();
                        $('select#desa_lembaga').attr('disabled', '').children().remove();
                    } else {
                        $('select#kabupaten_lembaga').children().remove();
                        $('select#kecamatan_lembaga').attr('disabled', '').children().remove();
                        $('select#desa_lembaga').attr('disabled', '').children().remove();
                        $('select#kabupaten_lembaga').removeAttr('disabled').append(`<option value="0">Pilih Kabupaten</option>`)
                        res.data.forEach(d =>
                            $('select#kabupaten_lembaga').append(`<option value="${d.kabupaten_id}">${d.nama_kabupaten}</option>`)
                        )
                    }
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kabupaten: " + err)
                }
            })
        })

        $('select#kabupaten_lembaga').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/kecamatan/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#kecamatan_lembaga').attr('disabled', '').children().remove();
                        $('select#desa_lembaga').attr('disabled', '').children().remove();
                    } else {
                        $('select#kecamatan_lembaga').children().remove();
                        $('select#desa_lembaga').attr('disabled', '').children().remove();
                        $('select#kecamatan_lembaga').removeAttr('disabled').append(`<option value="0">Pilih Kecamatan</option>`)
                        res.data.forEach(d =>
                            $('select#kecamatan_lembaga').append(`<option value="${d.kecamatan_id}">${d.nama_kecamatan}</option>`)
                        )
                    }
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kecamatan: " + err)
                }
            })
        })

        $('select#kecamatan_lembaga').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/desa/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#desa_lembaga').attr('disabled', '').children().remove();
                    } else {
                        $('select#desa_lembaga').children().remove();
                        $('select#desa_lembaga').removeAttr('disabled').append(`<option value="0">Pilih Desa</option>`)
                        res.data.forEach(d =>
                            $('select#desa_lembaga').append(`<option value="${d.desa_id}">${d.nama_desa}</option>`)
                        )
                    }
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kecamatan: " + err)
                }
            })
        })

        $('select#provinsi').on('change', function(e) {
            $.ajax({
                url: document.location.origin + '/home/kabupaten/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#kabupaten').attr('disabled', '').children().remove();
                        $('select#kecamatan').attr('disabled', '').children().remove();
                        $('select#desa').attr('disabled', '').children().remove();
                    } else {
                        $('select#kecamatan').attr('disabled', '').children().remove();
                        $('select#desa').attr('disabled', '').children().remove();
                        $('select#kabupaten').children().remove();
                        $('select#kabupaten').removeAttr('disabled').append(`<option value="0">Pilih Kabupaten</option>`)
                        res.data.forEach(d =>
                            $('select#kabupaten').append(`<option value="${d.kabupaten_id}">${d.nama_kabupaten}</option>`)
                        )
                    }
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kabupaten: " + err)
                }
            })
        })

        $('select#kabupaten').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/kecamatan/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#kecamatan').attr('disabled', '').children().remove();
                        $('select#desa').attr('disabled', '').children().remove();
                    } else {
                        $('select#desa').attr('disabled', '').children().remove();
                        $('select#kecamatan').children().remove();
                        $('select#kecamatan').removeAttr('disabled').append(`<option value="0">Pilih Kecamatan</option>`)
                        res.data.forEach(d =>
                            $('select#kecamatan').append(`<option value="${d.kecamatan_id}">${d.nama_kecamatan}</option>`)
                        )
                    }
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kecamatan: " + err)
                }
            })
        })

        $('select#kecamatan').on('change', function() {
            $.ajax({
                url: document.location.origin + '/home/desa/' + $(this).val(),
                method: 'get',
                dataType:'json',
                success: function(res) {
                    if(res.data.length == 0) {
                        $('select#desa').attr('disabled', '').children().remove();
                    } else {
                        $('select#desa').children().remove();
                        $('select#desa').removeAttr('disabled').append(`<option value="0">Pilih Desa</option>`)
                        res.data.forEach(d =>
                            $('select#desa').append(`<option value="${d.desa_id}">${d.nama_desa}</option>`)
                        )
                    }
                },
                error: function(err) {
                    console.error("Terjadi kesalahan saat ambil data kecamatan: " + err)
                }
            })
        })

        $('.check-password').on('click', function() {
            if($('input.password').attr('type') == 'text') {
                $('input.password').attr('type', 'password')
                $(this).children('span').removeClass('fa-eye-slash');
                $(this).children('span').addClass('fa-eye');
            } else {
                $('input.password').attr('type', 'text')
                $(this).children('span').removeClass('fa-eye');
                $(this).children('span').addClass('fa-eye-slash');
            }
        })

        $('.custom-file-input').on('change', function(e) {
            let id = $(this).attr('id');
            let lembaga = $(this).hasClass('lembaga')

            $(this).siblings().text(e.target.value.split("fakepath")[1]);
            var input = $(e.currentTarget);
            var file = input[0].files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                if(lembaga) {
                    $("#" + id + '_show_lembaga').attr("src", e.target.result);
                    $("#" + id + '_show_lembaga').removeClass("d-none");
                } else {
                    $("#" + id + '_show').attr("src", e.target.result);
                    $("#" + id + '_show').removeClass("d-none");
                }
            };
            reader.readAsDataURL(file);
        })

        $('#nik').on('keyup', function(e) {
            $('.count-nik').text(e.target.value.length)
            if(e.target.value.length > 16) {
                $('.count-nik').parent('p').removeClass('text-muted text-success').addClass('text-danger')
            } else if (e.target.value.length == 16) {
                $('.count-nik').parent('p').removeClass('text-danger text-muted').addClass('text-success')
            } else {
                $('.count-nik').parent('p').removeClass('text-danger text-success').addClass('text-muted')
            }
        });
    }
    if(routeName == 'master.anggota.list.dokumen.create' || routeName == 'master.anggota.list.dokumen.edit') {
        $(".custom-file-input").on("change", function (e) {
            $(this).siblings().text(e.target.value.split("fakepath")[1]);
            var input = $(e.currentTarget);
            var file = input[0].files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".img.img-thumbnail.img-temporary").attr("src", e.target.result);
                $(".img.img-thumbnail.img-temporary").removeClass("d-none");
            };
            reader.readAsDataURL(file);
        });
    }
    if(routeName == 'master.lain.sesi') {
        $('.table-sesi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'master_sesi_lelang_id', name: 'master_sesi_lelang_id'},
                {data: 'nama_penyelenggara', name: 'nama_penyelenggara'},
                {data: 'sesi', name: 'sesi'},
                {data: 'jam_mulai', name: 'jam_mulai'},
                {data: 'jam_berakhir', name: 'jam_berakhir'},
                {data: 'is_aktif', name: 'is_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'master.lain.sesi.create' || routeName == 'master.lain.sesi.edit') {
        $("select#penyelenggara_pasar_lelang_id").select2({
            tags: true
        });
    }
    if(routeName == 'master.lain.rekening.create' || routeName == 'master.lain.rekening.edit') {
        $("select#penyelenggara_pasar_lelang_id").select2({
            tags: true
        });
        $("select#bank_id").select2({
            tags: true
        });
    }
    if(routeName == 'offline.event.produk.show' || routeName == 'online.event.history.show' || routeName == 'online.event.show') {
        $('#imageGallery').lightSlider({
            gallery:true,
            item:1,
            loop:true,
            thumbItem:9,
            slideMargin:0,
            enableDrag: false,
            currentPagerPosition:'left',
        });

        $(document).on('click', '.minus_penyerahan', function(e) {
            $(this).parent().parent().remove()
        });

        $('#plus_penyerahan').on('click', function() {
            let num = $('.body-penyerahan').children().length;
            $('.body-penyerahan').append('<tr><td><input type="date" class="form-control" name="waktu_penyerahan[]" /></td><td><input type="text" class="form-control" name="volume_penyerahan[]" /></td><td><button type="button" data-index="'+(num+1)+'" class="btn btn-sm btn-danger minus_penyerahan"><i class="fas fa-minus"></i></button></td></tr>')
        });

        $('.btn-custom-penjual').on('click', function(e) {
            $('.btn-tutup-custom').removeClass('d-none');
            $('.form-custom-buyer').removeClass('d-none');
            $('.btn-custom-penjual').addClass('d-none');
        });
        $('.btn-tutup-custom').on('click', function(e) {
            $('.btn-custom-penjual').removeClass('d-none');
            $('.form-custom-buyer').addClass('d-none');
            $('.btn-tutup-custom').addClass('d-none');
        });


    }
    if(routeName == 'offline.list.sesi_lelang') {
        var count = 0;
        var kodeBelow = 0;
        var harga_awal = $('#harga_awal').text().replaceAll(',', '')
        var kelipatan_harga = $('#kelipatan_harga').text().replaceAll(',', '')

        $('.btn_bid').on('click', function () {
            kodeBelow = $('#kode_peserta').text()

            $.ajax({
                url: document.location.pathname + '/api',
                data: {
                    'peserta': kodeBelow,
                    'harga': harga_awal,
                    'waktu': count,
                    'code': 'penawaran',
                    '_token': csrf
                },
                dataType: 'json',
                method: 'post',
                success: function(res) {
                    if(res.status == 'failed') {
                        window.alert(res.message)
                    }
                },
                error: function(err) {console.error(err)},
            })
        });


        $(function() {
            setInterval(function() {
                $.ajax({
                    url: document.location.pathname + '/api',
                    data:{
                        'code': 'getAnyRequest',
                        '_token': csrf,
                        'harga': 0,
                        'waktu': count,
                        'peserta': 0,
                        'length': $('div.riwayat_penawaran').length
                    },
                    dataType: 'json',
                    method: 'post',
                    success: function(res) {
                        if(res.done) {
                            // Selesai
                            $('.btn_not_started').addClass('d-none').removeClass('d-block');
                            $('.btn_bid').addClass('d-none').removeClass('d-block');
                            $('.btn_done').removeClass('d-none').addClass('d-block');
                        } else {
                            if(!res.aktif && res.reset) {
                                $('.btn_not_started').addClass('d-none').removeClass('d-block');
                                $('.btn_bid').addClass('d-none').removeClass('d-block');
                                $('.btn_done').removeClass('d-none').addClass('d-block');
                            }
                            if(res.aktif && res.reset) {
                                $('.btn_not_started').addClass('d-none').removeClass('d-block');
                                $('.btn_bid').removeClass('d-none').addClass('d-block');
                                $('.btn_done').addClass('d-none').removeClass('d-block');
                            }
                            if(!res.aktif && !res.reset) {
                                $('.btn_not_started').removeClass('d-none').addClass('d-block');
                                $('.btn_bid').addClass('d-none').removeClass('d-block');
                                $('.btn_done').addClass('d-none').removeClass('d-block');

                                if($('.riwayat_penawaran').children().length > 0) {
                                    $('.riwayat_penawaran').children().remove();
                                    $('#show_price').text($('#harga_awal').text());
                                    $('.riwayat_penawaran').append('<p>Belum ada Penawaran</p>');
                                }
                            }
                        }

                        var hours = ("0" + Math.floor(res.count / 3600)).slice(-2);
                        var minutes = ("0" + Math.floor((res.count - (hours * 3600)) / 60)).slice(-2);
                        var seconds = ("0" + (res.count - (hours * 3600) - (minutes * 60))).slice(-2);
                        document.getElementById("time").innerHTML = hours + ":" + minutes + ":" + seconds;

                        if(res.data.length > 0) {
                            if(res.aktif) {
                                $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data[res.data.length - 1].harga_ajuan.split('.')[0]) + parseInt(kelipatan_harga))).replaceAll('.', ','));
                            } else {
                                $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data[res.data.length - 1].harga_ajuan.split('.')[0]))).replaceAll('.', ','));
                            }
                            harga_awal = parseInt(res.data[res.data.length - 1].harga_ajuan.split('.')[0]) + parseInt(kelipatan_harga);

                            $('.riwayat_penawaran').children().remove();
                            res.data.forEach(x => {
                                var hours = ("0" + Math.floor(x.waktu / 3600)).slice(-2);
                                var minutes = ("0" + Math.floor((x.waktu - (hours * 3600)) / 60)).slice(-2);
                                var seconds = ("0" + (x.waktu - (hours * 3600) - (minutes * 60))).slice(-2);

                                    if($('div.riwayat_penawaran').children('p').length == 1) {
                                        $('.riwayat_penawaran').children('p').remove();
                                        $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                    } else {
                                        if($('div.riwayat_penawaran').children('ul').length == 0) {
                                            $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                        } else {
                                            $('.riwayat_penawaran').children('ul.list-group').prepend('<li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li>');
                                        }
                                    }
                            });
                        }
                    }, error: function(err) {
                        console.error(err);
                    }
                });
            }, 1000);
        });
    }
    if(routeName == 'offline.event.produk.sesi') {
        var count = 0;
        var kodeBelow = 0;
        var harga_awal = $('#harga_awal').text().replaceAll(',', '')
        var kelipatan_harga = $('#kelipatan_harga').text().replaceAll(',', '')

        $(function() {
            setInterval(function() {
                $.ajax({
                    url: document.location.pathname + '/api',
                    data:{
                        'code': 'getAnyRequest',
                        '_token': csrf,
                        'harga': 0,
                        'waktu': count,
                        'peserta': 0,
                        'length': $('div.riwayat_penawaran').length
                    },
                    dataType: 'json',
                    method: 'post',
                    success: function(res) {
                        if(res.done) {
                            // Selesai
                            $('#start_lelang').addClass('d-none')
                            $('#stop_lelang').addClass('d-none')
                            $('#closed_btn').removeClass('d-none');
                            $('.btn-peserta-lelang').attr('disabled', '');
                        } else {
                            if(!res.aktif && res.reset) {
                                // Reset
                                $('#btn_finish_lelang').removeClass('d-none');
                                $('#start_lelang').addClass('d-none')
                                $('#closed_btn').addClass('d-none')
                                $('#stop_lelang').addClass('d-none')
                                $('.btn-peserta-lelang').attr('disabled', '');
                            }
                            if(res.aktif && res.reset) {
                                $('#start_lelang').addClass('d-none')
                                $('#stop_lelang').removeClass('d-none')
                                $('#closed_btn').addClass('d-none')
                                $('#btn_finish_lelang').addClass('d-none');
                                $('.btn-peserta-lelang').removeAttr('disabled');
                            }
                            if(!res.aktif && !res.reset) {
                                $('#start_lelang').removeClass('d-none')
                                $('#stop_lelang').addClass('d-none')
                                $('#closed_btn').addClass('d-none')
                                $('#btn_finish_lelang').addClass('d-none');
                                $('.btn-peserta-lelang').attr('disabled', '');
                            }
                        }

                        var hours = ("0" + Math.floor(res.count / 3600)).slice(-2);
                        var minutes = ("0" + Math.floor((res.count - (hours * 3600)) / 60)).slice(-2);
                        var seconds = ("0" + (res.count - (hours * 3600) - (minutes * 60))).slice(-2);
                        document.getElementById("time").innerHTML = hours + ":" + minutes + ":" + seconds;

                        if(res.data.length > 0) {
                            if(res.aktif) {
                                $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data[res.data.length - 1].harga_ajuan.split('.')[0]) + parseInt(kelipatan_harga))).replaceAll('.', ','));
                            } else {
                                $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data[res.data.length - 1].harga_ajuan.split('.')[0]))).replaceAll('.', ','));
                            }
                            harga_awal = parseInt(res.data[res.data.length - 1].harga_ajuan.split('.')[0]) + parseInt(kelipatan_harga);

                            $('.riwayat_penawaran').children().remove();
                            res.data.forEach(x => {
                                var hours = ("0" + Math.floor(x.waktu / 3600)).slice(-2);
                                var minutes = ("0" + Math.floor((x.waktu - (hours * 3600)) / 60)).slice(-2);
                                var seconds = ("0" + (x.waktu - (hours * 3600) - (minutes * 60))).slice(-2);

                                    if($('div.riwayat_penawaran').children('p').length == 1) {
                                        $('.riwayat_penawaran').children('p').remove();
                                        $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                    } else {
                                        if($('div.riwayat_penawaran').children('ul').length == 0) {
                                            $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                        } else {
                                            $('.riwayat_penawaran').children('ul.list-group').prepend('<li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li>');
                                        }
                                    }
                            });
                        }
                    }, error: function(err) {
                        console.error(err);
                    }
                });
            }, 1000);
        });

        $('#start_lelang').on('click', function(){
            $('#start_lelang').addClass('d-none');
            $('#stop_lelang').removeClass('d-none').removeAttr('disabled');
            $('.btn-peserta-lelang').removeAttr('disabled');
            $.ajax({
                url: document.location.pathname + '/api',
                data: {
                    'peserta': '_',
                    'harga': '_',
                    'waktu': 0,
                    'code': 'startEventLelang',
                    '_token': csrf
                },
                dataType: 'json',
                method: 'post',
                success: function(res) {
                    // console.log(res)
                },
                error: function(err) {console.error(err)},
            });
        });
        $('#stop_lelang').on('click', function(){
            $('#btn_finish_lelang').removeClass('d-none')
            $('.btn-peserta-lelang').attr('disabled', '');
            $('#start_lelang').attr('disabled', '');
            $('#stop_lelang').addClass('d-none').attr('disabled', '');

            $.ajax({
                url: document.location.pathname + '/api',
                data: {
                    'peserta': '_',
                    'harga': '_',
                    'waktu': 0,
                    'code': 'stopSesiLelang',
                    '_token': csrf
                },
                dataType: 'json',
                method: 'post',
                success: function(res) {
                    // console.log(res)
                },
                error: function(err) {console.error(err)},
            });
        });

        $('#reset_lelang').on('click', function(){
            count = 0;
            var hours = ("0" + Math.floor(count / 3600)).slice(-2);
            var minutes = ("0" + Math.floor((count - (hours * 3600)) / 60)).slice(-2);
            var seconds = ("0" + (count - (hours * 3600) - (minutes * 60))).slice(-2);
            document.getElementById("time").innerHTML = hours + ":" + minutes + ":" + seconds;
            $('div.riwayat_penawaran').children().remove();
            $('div.riwayat_penawaran').append('<p class="text-muted">Belum ada Penawaran</p>');
            var harga_awal = $('#harga_awal').text().replaceAll(',', '')
            $('#show_price').text((Intl.NumberFormat().format(harga_awal)).replaceAll('.', ','))
            $('#btn_finish_lelang').addClass('d-none');
            $('#start_lelang').removeAttr('disabled').removeClass('d-none');

            $.ajax({
                url: document.location.pathname + '/api',
                data: {
                    'peserta': kodeBelow,
                    'harga': harga_awal,
                    'waktu': count,
                    'code': 'reset',
                    '_token': csrf
                },
                dataType: 'json',
                method: 'post',
                success: function(res) {
                    // console.log(res)
                },
                error: function(err) {console.error(err)},
            });
        });

        $('#selesai_lelang').on('click', function(){
            $.ajax({
                url: document.location.pathname + '/api',
                data: {
                    'peserta': kodeBelow,
                    'harga': harga_awal,
                    'waktu': count,
                    'code': 'selesai',
                    '_token': csrf
                },
                dataType: 'json',
                method: 'post',
                success: function(res) {
                    if(res.status == 'success') {
                        $('#closed_btn').removeClass('d-none')
                        $('#btn_finish_lelang').addClass('d-none');
                    }
                },
                error: function(err) {console.error(err)},
            })
        });

        $('.btn-peserta-lelang').on('click', getKodePesertaLelang);

        function getKodePesertaLelang () {
            if ($(this).data('kode') != kodeBelow) {
                kodeBelow = $(this).data('kode');

                $.ajax({
                    url: document.location.pathname + '/api',
                    data: {
                        'peserta': kodeBelow,
                        'harga': harga_awal,
                        'waktu': count,
                        'code': 'penawaran',
                        '_token': csrf
                    },
                    dataType: 'json',
                    method: 'post',
                    success: function(res) {
                        // console.log(res)
                    },
                    error: function(err) {console.error(err)},
                })
            }
        }

    }
    if(routeName == 'administrasi.kas_bank.verifikasi.index') {
        $('.table-kas_bank-verifikasi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'keuangan_id', name: 'keuangan_id'},
                {data: 'jenis_transaksi', name: 'jenis_transaksi'},
                {data: 'kurs_mata_uang', name: 'kurs_mata_uang'},
                {data: 'saldo', name: 'saldo'},
                {data: 'jumlah', name: 'jumlah'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.kas_bank.verifikasi.index_ditolak') {
        $('.table-kas_bank-verifikasi-tolak').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'keuangan_id', name: 'keuangan_id'},
                {data: 'jenis_transaksi', name: 'jenis_transaksi'},
                {data: 'kurs_mata_uang', name: 'kurs_mata_uang'},
                {data: 'saldo', name: 'saldo'},
                {data: 'jumlah', name: 'jumlah'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.kas_bank.list.index') {
        $('.table-kas_bank-list').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'keuangan_id', name: 'keuangan_id'},
                {data: 'jenis_transaksi', name: 'jenis_transaksi'},
                {data: 'kurs_mata_uang', name: 'kurs_mata_uang'},
                {data: 'saldo', name: 'saldo'},
                {data: 'jumlah', name: 'jumlah'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.kas_bank.penerimaan.index') {
        $('.table-kas_bank-penerimaan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'keuangan_id', name: 'keuangan_id'},
                {data: 'jenis_transaksi', name: 'jenis_transaksi'},
                {data: 'kurs_mata_uang', name: 'kurs_mata_uang'},
                {data: 'saldo', name: 'saldo'},
                {data: 'jumlah', name: 'jumlah'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.kas_bank.penerimaan.create') {
        $("select#member_id").select2({
            tags: true
        });
        $("select#kurs_mata_uang_id").select2({
            tags: true
        });
        $("select#jenis_transaksi_id").select2({
            tags: true
        });
        $("select#jenis_alokasi").select2({
            tags: true
        });
        $("select#no_rekening_tujuan_id").select2({
            tags: true
        });

        // Logic

        let temp = 'Cash / Bank In (Trading)';
        $('.cash-in').addClass('d-none')
                $('.cash-in-non').addClass('d-none')
                $('.settlement').addClass('d-none')
                $('.pengembalian-collateral').addClass('d-none')

                $('.cash-in').removeClass('d-none')

        $('select#member_id').on('change', function(e) {
            $.ajax({
                url: document.location.href + '/api',
                method: 'get',
                data: {
                    member: e.target.value
                },
                dataType: 'json',
                success: function(res) {
                    $('select#rekening_bank_id').attr('disabled');
                    $('select#rekening_bank_id').children().remove();

                    if(res.data.length  > 0) {
                        res.data.forEach(e => {
                            $('select#rekening_bank_id').append('<option value="'+ e.rekening_bank_id +'">'+ e.nama_bank +' ('+ e.nomor_rekening +')</option>');
                            $('select#rekening_bank_id').removeAttr('disabled')
                        });
                    } else {
                        $('select#rekening_bank_id').attr('disabled')
                    }
                },
                error: function(err) {
                    console.error(err)
                }
            })
        });
        $('select#jenis_transaksi_id').on('change', function(e) {
            temp = (e.target.value);
            if(temp == 'Cash / Bank In (Trading)') {
                $('.cash-in').addClass('d-none')
                $('.cash-in-non').addClass('d-none')
                $('.settlement').addClass('d-none')
                $('.pengembalian-collateral').addClass('d-none')

                $('.cash-in').removeClass('d-none')
            }
            else if(temp == 'Cash / Bank In (Non-Trading)') {
                $('.cash-in').addClass('d-none')
                $('.cash-in-non').addClass('d-none')
                $('.settlement').addClass('d-none')
                $('.pengembalian-collateral').addClass('d-none')

                $('.cash-in-non').removeClass('d-none')
            }
            else if(temp == 'Cash / Bank Out (Settlement)') {
                $('.cash-in').addClass('d-none')
                $('.cash-in-non').addClass('d-none')
                $('.settlement').addClass('d-none')
                $('.pengembalian-collateral').addClass('d-none')

                $('.settlement').removeClass('d-none')
            }
            else if(temp == 'Cash / Bank Out (Pembayaran Fee)') {
                $('.cash-in').addClass('d-none')
                $('.cash-in-non').addClass('d-none')
                $('.settlement').addClass('d-none')
                $('.pengembalian-collateral').addClass('d-none')
            }
            else if(temp == 'Cash / Bank Out (Pengembalian Collateral)') {
                $('.cash-in').addClass('d-none')
                $('.cash-in-non').addClass('d-none')
                $('.settlement').addClass('d-none')
                $('.pengembalian-collateral').addClass('d-none')

                $('.pengembalian-collateral').removeClass('d-none')
            }
            else {
                $('.cash-in').addClass('d-none')
                $('.cash-in-non').addClass('d-none')
                $('.settlement').addClass('d-none')
                $('.pengembalian-collateral').addClass('d-none')
                $('.cash-in').removeClass('d-none')
            }
        });


        //End Logic
    }
    if(routeName == 'administrasi.gudang.penerimaan.index') {
        $('.table-gudang-penerimaan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'transaksi_id', name: 'transaksi_id'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'jenis_registrasi', name: 'jenis_registrasi'},
                {data: 'gudang', name: 'gudang'},
                {data: 'anggota', name: 'anggota'},
                {data: 'komoditas', name: 'komoditas'},
                {data: 'nilai', name: 'nilai'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.gudang.penerimaan.create' || routeName == 'administrasi.gudang.penerimaan.edit') {
        $("select#informasi_akun_id").select2({
            tags: true
        });
        $("select#mutu_id").select2({
            tags: true
        });
        $("select#jenis_registrasi_id").select2({
            tags: true
        });
        $("select#komoditas_id").select2({
            tags: true
        });
        $("select#gudang_id").select2({
            tags: true
        });
        $("#komoditas_id").on('change', function(e) {
            $.ajax({
                url: document.location.origin + '/master/lain/komoditas/cek-satuan',
                method: 'get',
                data: {
                    _token: csrf,
                    komoditas_id: e.target.value
                },
                dataType: 'json',
                success: function(res) {
                    $('span.komoditas-satuan-ukuran').html(res.data.satuan_ukuran);
                },
                error: function(err) {
                    console.error(err)
                }
            })
        })

        let temp = null;

        $('select#jenis_registrasi_id').on('change', function(e) {
            temp = (e.target.value);

            if (temp == 'Registrasi Komoditas (IN)') {
                $('.reg-in').removeClass('d-none')
            } else {
                $('.reg-in').addClass('d-none')
            }
        });
    }
    if(routeName == 'administrasi.gudang.verifikasi.index') {
        $('.table-gudang-verifikasi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'transaksi_id', name: 'transaksi_id'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'jenis_registrasi', name: 'jenis_registrasi'},
                {data: 'gudang', name: 'gudang'},
                {data: 'anggota', name: 'anggota'},
                {data: 'komoditas', name: 'komoditas'},
                {data: 'nilai', name: 'nilai'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.gudang.verifikasi.index_ditolak') {
        $('.table-gudang-verifikasi-tolak').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'transaksi_id', name: 'transaksi_id'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'jenis_registrasi', name: 'jenis_registrasi'},
                {data: 'gudang', name: 'gudang'},
                {data: 'anggota', name: 'anggota'},
                {data: 'komoditas', name: 'komoditas'},
                {data: 'nilai', name: 'nilai'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.gudang.list.index') {
        $('.table-gudang-list').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'transaksi_id', name: 'transaksi_id'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'jenis_registrasi', name: 'jenis_registrasi'},
                {data: 'gudang', name: 'gudang'},
                {data: 'anggota', name: 'anggota'},
                {data: 'komoditas', name: 'komoditas'},
                {data: 'nilai', name: 'nilai'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.penerimaan.list.index') {
        $('.table-jaminan-penerimaan-list').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
                {data: 'nama', name: 'nama'},
                {data: 'nilai_jaminan', name: 'nilai_jaminan'},
                {data: 'nilai_penyesuaian', name: 'nilai_penyesuaian'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.penerimaan.index') {
        $('.table-jaminan-penerimaan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
                {data: 'nama', name: 'nama'},
                {data: 'nilai_jaminan', name: 'nilai_jaminan'},
                {data: 'nilai_penyesuaian', name: 'nilai_penyesuaian'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.penerimaan.create' || routeName == 'administrasi.jaminan.penerimaan.edit') {
        $("select#informasi_akun_id").select2({
            tags: true
        });

        $("select#informasi_akun_id").on('change', function(e){
            $.ajax({
                url: document.location.href + '/api',
                method: 'get',
                data: {
                    _token: csrf,
                    informasi_akun_id: e.target.value,
                    code: 'get-jaminan'
                },
                dataType: 'json',
                success: function(res) {
                    if(res.status == 'success') {
                        $('input#total_saldo_jaminan').val(res.data.total_saldo_jaminan)
                        $('input#saldo_teralokasi').val(res.data.saldo_teralokasi)
                        $('input#saldo_tersedia').val(res.data.saldo_tersedia)
                    }
                },
                error: function(err) {
                    console.error(err);
                },
            })
        })
    }
    if(routeName == 'administrasi.jaminan.penerimaan.kas.index') {
        $('.table-jaminan-kas').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'kode_mata_uang', name: 'kode_mata_uang'},
                {data: 'kurs', name: 'kurs'},
                {data: 'nilai', name: 'nilai'},
                {data: 'nilai_penyesuaian', name: 'nilai_penyesuaian'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.penerimaan.komoditas.index') {
        $('.table-jaminan-komoditas').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'komoditi', name: 'komoditi'},
                {data: 'kuantitas', name: 'kuantitas'},
                {data: 'unit', name: 'unit'},
                {data: 'nilai_perkiraan', name: 'nilai_perkiraan'},
                {data: 'nilai_penyesuaian', name: 'nilai_penyesuaian'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.penerimaan.deposito.index') {
        $('.table-jaminan-deposito').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'tanggal_terima', name: 'tanggal_terima'},
                {data: 'tanggal_jatuh_tempo', name: 'tanggal_jatuh_tempo'},
                {data: 'nilai_nominal', name: 'nilai_nominal'},
                {data: 'haircut', name: 'haircut'},
                {data: 'nilai_tersedia', name: 'nilai_tersedia'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.penerimaan.obligasi.index') {
        $('.table-jaminan-obligasi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'jenis', name: 'jenis'},
                {data: 'tanggal_jatuh_tempo', name: 'tanggal_jatuh_tempo'},
                {data: 'nilai_nominal', name: 'nilai_nominal'},
                {data: 'haircut', name: 'haircut'},
                {data: 'nilai_tersedia', name: 'nilai_tersedia'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.penerimaan.saham.index') {
        $('.table-jaminan-saham').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'kode_saham', name: 'kode_saham'},
                {data: 'lot', name: 'lot'},
                {data: 'nilai_saham', name: 'nilai_saham'},
                {data: 'haircut', name: 'haircut'},
                {data: 'nilai_tersedia', name: 'nilai_tersedia'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.penerimaan.saham.create' || routeName == 'administrasi.jaminan.penerimaan.saham.edit') {
        let harga_saham = 0, lot = 0;
        $('input#harga_saham').on('change', function(e) {
            harga_saham = String(e.target.value)
            if(typeof lot == 'number') {
                lot = $('input#lot') != '' ? String($('input#lot').val()) : String(lot)
            }
            calculatePriceAndLot()
        });

        $('input#lot').on('change', function(e) {
            lot = String(e.target.value);
            if(typeof harga_saham == 'number') {
                harga_saham = $('input#harga_saham') != '' ? String($('input#harga_saham').val()) : String(harga_saham)
            }
            calculatePriceAndLot()
        });

        function calculatePriceAndLot () {

            if(harga_saham.includes('.')) {
                harga_saham = harga_saham.split('.')[0];
            }
            if(lot.includes('.')) {
                lot = lot.split('.')[0];
            }

            harga_saham = harga_saham.replaceAll(',', '');
            lot = lot.replaceAll(',', '');

            $('input#nilai_saham').val(((parseInt(harga_saham) * parseInt(lot)).toLocaleString()).replaceAll('.', ','));
        }
    }
    if(routeName == 'administrasi.jaminan.penerimaan.resi_gudang.index') {
        $('.table-jaminan-resi_gudang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'nama_resi_gudang', name: 'nama_resi_gudang'},
                {data: 'tanggal_jatuh_tempo', name: 'tanggal_jatuh_tempo'},
                {data: 'nilai_resi_gudang', name: 'nilai_resi_gudang'},
                {data: 'haircut', name: 'haircut'},
                {data: 'nilai_tersedia', name: 'nilai_tersedia'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.penerimaan.verifikasi.index' || routeName == 'administrasi.jaminan.penerimaan.verifikasi.index_ditolak') {
        $('.table-jaminan-verifikasi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'nama', name: 'nama'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'nilai_jaminan', name: 'nilai_jaminan'},
                {data: 'haircut', name: 'haircut'},
                {data: 'nilai_penyesuaian', name: 'nilai_penyesuaian'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'notifikasi') {
        $('.table-notifikasi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'notifikasi_id', name: 'notifikasi_id'},
                {data: 'judul', name: 'judul'},
                {data: 'konten', name: 'konten'},
                {data: 'is_read', name: 'is_read'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.pengeluaran.index') {
        $('.table-jaminan-pengeluaran').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'kode_transaksi', name: 'kode_transaksi'},
                {data: 'jenis', name: 'jenis'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'nama', name: 'nama'},
                {data: 'jumlah', name: 'jumlah'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'administrasi.jaminan.pengeluaran.create' || routeName == 'administrasi.jaminan.pengeluaran.edit') {
        $("select#informasi_akun_id").select2({
            tags: true
        });
        $("select#jenis_pengeluaran_jaminan_id").select2({
            tags: true
        });

        $('select#jenis_pengeluaran_jaminan_id').on('change', function(e) {
            if(e.target.value == 'Release Commodity Collateral') {
                $('.return-cash').addClass('d-none')
                $('.jaminan_komoditas').addClass('d-none')
                $('.release-cash').addClass('d-none')

                $('.jaminan_komoditas').removeClass('d-none')
            }
            if(e.target.value == 'Return Cash Collateral') {
                $('.return-cash').addClass('d-none')
                $('.jaminan_komoditas').addClass('d-none')
                $('.release-cash').addClass('d-none')

                $('.return-cash').removeClass('d-none')
            }
            if(e.target.value == 'Release Cash Collateral') {
                $('.return-cash').addClass('d-none')
                $('.jaminan_komoditas').addClass('d-none')
                $('.release-cash').addClass('d-none')

                $('.release-cash').removeClass('d-none')
            }
        });

        $('select#informasi_akun_id').on('change', function(e) {
            $.ajax({
                url: document.location.href + '/get-komoditas',
                method: 'get',
                data: {
                    _token: csrf,
                    informasi_akun_id: e.target.value,
                },
                dataType: 'json',
                beforeSend: function() {
                    $('select#registrasi_komoditas_jaminan_id').append('<option>Loading ...</option>');
                },
                success: function(res) {
                    $('select#registrasi_komoditas_jaminan_id').children().remove();
                    if(res.status == 'success') {
                        $('#saldo_tersedia').val(parseInt(res.data.total_saldo_tersedia).toLocaleString().replaceAll('.', ','));
                        if(res.data.komoditas.length > 0) {
                            res.data.komoditas.forEach(a => {
                                $('select#registrasi_komoditas_jaminan_id').append('<option data-kuantitas="'+ a.kuantitas +'" data-perkiraan="' + a.nilai_perkiraan.split('.')[0] + '" data-penyesuaian="' + a.nilai_penyesuaian.split('.')[0] + '" value="'+ a.registrasi_komoditas_jaminan_id +'">'+ a.komoditi + ' ('+ a.kuantitas +' '+ a.unit +')' +'</option>');
                            });
                            $('select#registrasi_komoditas_jaminan_id').removeAttr('disabled')
                        } else {
                            $('select#registrasi_komoditas_jaminan_id').attr('disabled', '')
                            $('select#registrasi_komoditas_jaminan_id').append('<option>Tidak ada Jaminan Komoditas ...</option>');
                        }
                    }
                },
                error: function(err) {
                    $('select#registrasi_komoditas_jaminan_id').children().remove();
                    console.error(err)
                }
            });
        });

        $('input#qty_settlement').on('change', function(e) {
            let penyesuaian = parseFloat($('select#registrasi_komoditas_jaminan_id').children('option[value='+ $('select#registrasi_komoditas_jaminan_id').val() +']').attr('data-penyesuaian'));
            let kuantitas = parseFloat($('select#registrasi_komoditas_jaminan_id').children('option[value='+ $('select#registrasi_komoditas_jaminan_id').val() +']').attr('data-kuantitas').split('.')[0]);
            if(e.target.value > 0 && e.target.value <= kuantitas) {
                $('input#alokasi_settlement').val(((penyesuaian / kuantitas) * e.target.value).toLocaleString().replaceAll('.', ','));
            } else {
                $('input#alokasi_settlement').val(0);
            }
        })
    }
    if(routeName == 'administrasi.jaminan.pengeluaran.verifikasi.index' || routeName == 'administrasi.jaminan.pengeluaran.verifikasi.index_ditolak' || routeName == 'administrasi.jaminan.pengeluaran.list.index') {
        $('.table-jaminan-pengeluaran-verifikasi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'kode_transaksi', name: 'kode_transaksi'},
                {data: 'jenis', name: 'jenis'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'nama', name: 'nama'},
                {data: 'jumlah', name: 'jumlah'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'operational.lelang.transaksi.index') {
        $('.table-transaksi-lelang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'jatuh_tempo', name: 'jatuh_tempo'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'nomor_lelang', name: 'nomor_lelang'},
                {data: 'pembeli', name: 'pembeli'},
                {data: 'penjual', name: 'penjual'},
                {data: 'harga', name: 'harga'},
                {data: 'jenis', name: 'jenis'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'operational.lelang.transaksi.show') {
        $('#biaya_lain_lain_penjual').on('change', function(e) {
            let biaya_lain_penjual = e.target.value.replaceAll(',', '');
            let tagihanPenjual = $('#tagihan_penjual').val().replaceAll(',', '');
            let penyelesaianPembeli = $('#penyelesaian_komoditas_pembeli').val().replaceAll(',', '');

            $('#penyelesaian_komoditas_penjual').val(((parseFloat(tagihanPenjual) + parseFloat(biaya_lain_penjual)).toLocaleString()).replaceAll('.', ','));
            $('#total_dibayar_ke_penjual').val(((parseFloat(penyelesaianPembeli) - (parseFloat(tagihanPenjual) + parseFloat(biaya_lain_penjual))).toLocaleString()).replaceAll('.', ','));
        });

        $('#biaya_lain_lain_pembeli').on('change', function(e) {
            let biaya_lain_pembeli = e.target.value.replaceAll(',', '');
            let tagihanPembeli = $('#tagihan_pembeli').val().replaceAll(',', '');
            let penyelesaianPenjual = $('#penyelesaian_komoditas_penjual').val().replaceAll(',', '');

            $('#penyelesaian_komoditas_pembeli').val(((parseFloat(tagihanPembeli) + parseFloat(biaya_lain_pembeli)).toLocaleString()).replaceAll('.', ','));
            $('#total_dibayar_ke_penjual').val((( (parseFloat(tagihanPembeli) + parseFloat(biaya_lain_pembeli)) - penyelesaianPenjual ).toLocaleString()).replaceAll('.', ','));
        });
    }
    if (routeName == 'operational.lelang.verifikasi.index' || routeName == 'operational.lelang.verifikasi.index_ditolak') {
        $('.table-lelang-verifikasi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'jatuh_tempo', name: 'jatuh_tempo'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'nomor_lelang', name: 'nomor_lelang'},
                {data: 'pembeli', name: 'pembeli'},
                {data: 'penjual', name: 'penjual'},
                {data: 'harga', name: 'harga'},
                {data: 'jenis', name: 'jenis'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'operational.lelang.list.index') {
        $('.table-lelang-list').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'jatuh_tempo', name: 'jatuh_tempo'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'nomor_lelang', name: 'nomor_lelang'},
                {data: 'pembeli', name: 'pembeli'},
                {data: 'penjual', name: 'penjual'},
                {data: 'harga', name: 'harga'},
                {data: 'jenis', name: 'jenis'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.role') {
        $('.table-role').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'role_id', name: 'role_id'},
                {data: 'nama_role', name: 'nama_role'},
                {data: 'is_aktif', name: 'is_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.mutu') {
        $('.table-mutu').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'mutu_id', name: 'mutu_id'},
                {data: 'nama_mutu', name: 'nama_mutu'},
                {data: 'is_aktif', name: 'is_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.status.member') {
        $('.table-status-member').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'status_member_id', name: 'status_member_id'},
                {data: 'nama_status', name: 'nama_status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.status.lelang') {
        $('.table-status-lelang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'status_lelang_id', name: 'status_lelang_id'},
                {data: 'nama_status', name: 'nama_status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.status.event_lelang') {
        $('.table-status-event_lelang').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'status_event_lelang_id', name: 'status_event_lelang_id'},
                {data: 'nama_status', name: 'nama_status'},
                {data: 'is_aktif', name: 'is_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.jenis.harga') {
        $('.table-jenis-harga').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'jenis_harga_id', name: 'jenis_harga_id'},
                {data: 'nama_jenis_harga', name: 'nama_jenis_harga'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.jenis.perdagangan') {
        $('.table-jenis-perdagangan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'jenis_perdagangan_id', name: 'jenis_perdagangan_id'},
                {data: 'nama_perdagangan', name: 'nama_perdagangan'},
                {data: 'is_aktif', name: 'is_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'administrasi.kas_bank.penerimaan.file.index' || routeName == 'administrasi.kas_bank.list.file.index' || routeName == 'administrasi.kas_bank.verifikasi.file.index') {
        $('.table-kas_bank-penerimaan-file').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'file_keuangan_id', name: 'file_keuangan_id'},
                {data: 'tanggal_upload', name: 'tanggal_upload'},
                {data: 'nama_dokumen', name: 'nama_dokumen'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.jenis.inisiasi') {
        $('.table-jenis-inisiasi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'jenis_inisiasi_id', name: 'jenis_inisiasi_id'},
                {data: 'nama_inisiasi', name: 'nama_inisiasi'},
                {data: 'is_aktif', name: 'is_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.admin.create') {
        $('.table-member-aktif').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'member_id', name: 'member_id'},
                {data: 'nik', name: 'nik'},
                {data: 'nama', name: 'nama'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.dana_keuangan') {
        $('.table-dana-keuangan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'dana_keuangan_id', name: 'dana_keuangan_id'},
                {data: 'jenis', name: 'jenis'},
                {data: 'jumlah_dana', name: 'jumlah_dana'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.rekening_pusat.create' || routeName == 'konfigurasi.rekening_pusat.edit') {
        $("select#bank_id").select2({
            tags: true
        });
        $("select#mata_uang").select2({
            tags: true
        });
        $("select#aktif").select2({
            tags: true
        });
        $("select#status").select2({
            tags: true
        });
    }
    if (routeName == 'konfigurasi.rekening_pusat') {
        $('.table-rekening-pusat').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'rekening_pusat_id', name: 'rekening_pusat_id'},
                {data: 'nama_bank', name: 'nama_bank'},
                {data: 'nomor_rekening', name: 'nomor_rekening'},
                {data: 'saldo', name: 'saldo'},
                {data: 'aktif', name: 'aktif'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.admin') {
        $('.table-admin').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'admin_id', name: 'admin_id'},
                {data: 'nik', name: 'nik'},
                {data: 'nama', name: 'nama'},
                {data: 'is_aktif', name: 'is_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.dinas') {
        $('.table-dinas').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'nik', name: 'nik'},
                {data: 'nama', name: 'nama'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.dinas.create') {
        $('.table-member-aktif').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'member_id', name: 'member_id'},
                {data: 'nik', name: 'nik'},
                {data: 'nama', name: 'nama'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.aplikasi.carousel') {
        $('.table-carousel').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'gambar', name: 'gambar'},
                {data: 'halaman', name: 'halaman'},
                {data: 'urutan', name: 'urutan'},
                {data: 'title', name: 'title'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.aplikasi.web_link') {
        $('.table-web-link').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'nama_web', name: 'nama_web'},
                {data: 'link', name: 'link'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.area.provinsi') {
        $('.table-provinsi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'provinsi_id', name: 'provinsi_id'},
                {data: 'nama_provinsi', name: 'nama_provinsi'},
                {data: 'kabupaten', name: 'kabupaten'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.area.provinsi.kabupaten') {
        $('.table-kabupaten').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'kabupaten_id', name: 'kabupaten_id'},
                {data: 'nama_kabupaten', name: 'nama_kabupaten'},
                {data: 'kecamatan', name: 'kecamatan'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.area.provinsi.kabupaten.kecamatan') {
        $('.table-kecamatan').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'kecamatan_id', name: 'kecamatan_id'},
                {data: 'nama_kecamatan', name: 'nama_kecamatan'},
                {data: 'desa', name: 'desa'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'konfigurasi.area.provinsi.kabupaten.kecamatan.desa') {
        $('.table-desa').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'desa_id', name: 'desa_id'},
                {data: 'nama_desa', name: 'nama_desa'},
                {data: 'member', name: 'member'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'laporan.jaminan') {
        $('#member_id').select2({
            minimumInputLength: 2,
            tags: [],
            ajax: {
                url: document.location.origin + '/laporan/api',
                dataType: 'json',
                delay: 250,
                type: 'GET',
                data: function (params) {
                    return {
                        token: csrf,
                        jenis: 'member',
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.nama + ' (' + item.nik + ')',
                                id: item.member_id
                            }
                        })
                    };
                },
                cache: true
            },
        });
        $("select#jenis").select2({
            tags: true
        });
    }
    if (routeName == 'laporan.daftar_anggota') {
        $('#chooser').on('change', function(e) {
            if(e.target.value == '1') {
                $('.choose-perorangan').removeClass('d-none')
                $('.choose-semua').addClass('d-none')
                $('.choose-lembaga').addClass('d-none')
            } else if(e.target.value == '2' || e.target.value == '4') {
                $('.choose-lembaga').addClass('d-none')
                $('.choose-perorangan').addClass('d-none')
                $('.choose-semua').removeClass('d-none')
            } else if(e.target.value == '3') {
                $('.choose-lembaga').removeClass('d-none')
                $('.choose-perorangan').addClass('d-none')
                $('.choose-semua').addClass('d-none')
            } else {
                return;
            }
        });

        $('#member_id').select2({
            minimumInputLength: 2,
            tags: [],
            ajax: {
                url: document.location.origin + '/laporan/api',
                dataType: 'json',
                delay: 250,
                type: 'GET',
                data: function (params) {
                    return {
                        token: csrf,
                        jenis: 'member',
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.nama + ' (' + item.nik + ')',
                                id: item.member_id
                            }
                        })
                    };
                },
                cache: true
            },
        });

        $('#lembaga_id').select2({
            minimumInputLength: 2,
            tags: [],
            ajax: {
                url: document.location.origin + '/laporan/api',
                dataType: 'json',
                delay: 250,
                type: 'GET',
                data: function (params) {
                    return {
                        token: csrf,
                        jenis: 'lembaga',
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.nama_lembaga ,
                                id: item.lembaga_id
                            }
                        })
                    };
                },
                cache: true
            },
        });
        $("select#status").select2({
            tags: true
        });
    }
    if (routeName == 'laporan.transaksi_bank') {
        $('#member_id').select2({
            minimumInputLength: 2,
            tags: [],
            ajax: {
                url: document.location.origin + '/laporan/api',
                dataType: 'json',
                delay: 250,
                type: 'GET',
                data: function (params) {
                    return {
                        token: csrf,
                        jenis: 'member',
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.nama + ' (' + item.nik + ')',
                                id: item.member_id
                            }
                        })
                    };
                },
                cache: true
            },
        });
        $("select#jenis_transaksi_id").select2({
            tags: true
        });
    }
    if (routeName == 'laporan.lelang') {
        $("select#penyelenggara_pasar_lelang_id").select2({
            tags: true
        });
        $("select#sesi").select2({
            tags: true
        });
    }
    if (routeName == 'laporan.event_lelang') {
        $('#event_lelang_id').select2({
            minimumInputLength: 2,
            tags: [],
            ajax: {
                url: document.location.origin + '/laporan/event_lelang/api',
                dataType: 'json',
                delay: 250,
                type: 'GET',
                data: function (params) {
                    return {
                        token: csrf,
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.nama_lelang + ' (' + item.event_kode + ')',
                                id: item.event_lelang_id
                            }
                        })
                    };
                },
                cache: true
            },
        });
    }
    if (routeName == 'blog.kategori') {
        $('.table-blog-kategori').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'blog_kategori_id', name: 'blog_kategori_id'},
                {data: 'title', name: 'title'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'blog.kategori.create' || routeName == 'blog.kategori.edit') {
        $('input#title').on('change', function(e) {
            $('input#slug').val(e.target.value.toLowerCase().replaceAll(' ', '-'));
        })
    }
    if (routeName == 'blog.post.create' || routeName == 'blog.post.edit') {
        $("select#kategori").select2({
            tags: true
        });
        $("select#tag").select2({
            multiple: true,
        });
        $('input#title').on('change', function(e) {
            $('input#slug').val(e.target.value.toLowerCase().replaceAll(' ', '-'));
        })

        if(routeName == 'blog.post.edit') {
            let temp = $('input[name=tagHelper]').val().split(';')
            $("select#tag").val(temp);
        }
    }
    if (routeName == 'blog.post.meta') {
        $('.table-blog-post-meta').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'key', name: 'key'},
                {data: 'content', name: 'content'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'blog.post') {
        $('.table-blog-post').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'published_at', name: 'published_at'},
                {data: 'kategori', name: 'kategori'},
                {data: 'title', name: 'title'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'blog.tag') {
        $('.table-blog-tag').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'blog_tag_id', name: 'blog_tag_id'},
                {data: 'title', name: 'title'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'blog.tag.create' || routeName == 'blog.tag.edit') {
        $('input#title').on('change', function(e) {
            $('input#slug').val(e.target.value.toLowerCase().replaceAll(' ', '-'));
        })
    }
    if (routeName == 'konfigurasi.laporan.perjanjian_jual_beli') {
        $('.table-laporan-perjanjian').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'perjanjian_jual_beli_pasal_id', name: 'perjanjian_jual_beli_pasal_id'},
                {data: 'key', name: 'key'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'konfigurasi.aplikasi.aplikasi') {
        $('.table-aplikasi').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'aplikasi_id', name: 'aplikasi_id'},
                {data: 'nama_aplikasi', name: 'nama_aplikasi'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if (routeName == 'laporan.transaksi_lelang') {
        $('#member_id').select2({
            minimumInputLength: 2,
            tags: [],
            ajax: {
                url: document.location.origin + '/laporan/api',
                dataType: 'json',
                delay: 250,
                type: 'GET',
                data: function (params) {
                    return {
                        token: csrf,
                        jenis: 'member',
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.nama + ' (' + item.nik + ')',
                                id: item.member_id
                            }
                        })
                    };
                },
                cache: true
            },
        });
        $("select#jenis").select2({
            tags: true
        });
    }
    $(".custom-file-input").on("change", function (e) {
        $(this).siblings().text(e.target.value.split("fakepath")[1]);
        var input = $(e.currentTarget);
        var file = input[0].files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".img.img-thumbnail.img-temporary").attr("src", e.target.result);
            $(".img.img-thumbnail.img-temporary").removeClass("d-none");
        };
        reader.readAsDataURL(file);
    });
    $("#logout-btn").on("click", function () {
        Swal.fire({
            title: "Keluar ?",
            text: "Keluar dari sistem e-KPB!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Keluar!",
            cancelButtonText: "Batalkan",
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("logout-form").submit();
            }
        });
    });
});
