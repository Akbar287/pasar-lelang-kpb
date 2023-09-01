"use strict";

const { default: Swal } = require("sweetalert2");
import Cleave from "cleave.js"
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

$(function () {
    let penawaranPadaHargaSatuan = null;
    let routeName = ($('meta[name=route]')[0].content);
    let csrf = ($('meta[name=csrf-token]')[0].content);

    if(penawaranPadaHargaSatuan == null) {
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

    if($('.thousand-style').toArray().length > 0) {
        $('.thousand-style').toArray().forEach(x => {
            new Cleave(x, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
        });
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
    if(routeName == 'home') {
        $.ajax({
            url: document.location.origin + '/api/chart',
            method: 'get',
            dataType: 'json',
            success: function(data) {
                new Chart(document.getElementById('chart-stok'), {
                    type: 'bar',
                    label: 'Stok BBM',
                    data: data.data.chart_stok,
                    options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                    }
                });
                new Chart(document.getElementById('chart-stok-split'), {
                    type: 'bar',
                    label: 'Pengeluaran Stok Tanggal 12 Juli 2023',
                    data: data.data.chart_stok_split,
                    options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                    }
                });
            },
            error: function(err) {console.error(err)}
        })
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
            })
        })
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
    if(routeName == 'online.event') {
        $('.table-lelang-event').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            ajax: document.location.href,
            columns: [
                {data: 'penyelenggara', name: 'penyelenggara'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'sesi', name: 'sesi'},
                {data: 'produk', name: 'produk'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
    if(routeName == 'offline.event') {
        $('.table-lelang-event').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
            },
            processing: true,
            serverSide: true,
            data: {
                tes: 'x'
            },
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
    if(routeName == 'master.kontrak.pengaturan' || routeName == 'master.kontrak.verifikasi' || routeName == 'master.kontrak.verifikasi.riwayat' || routeName == 'master.kontrak.list' || routeName == 'master.kontrak.nonaktif') {
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
    if(routeName == 'offline.event.produk.show') {
        $('#imageGallery').lightSlider({
            gallery:true,
            item:1,
            loop:true,
            thumbItem:9,
            slideMargin:0,
            enableDrag: false,
            currentPagerPosition:'left',
        });      
    }
    if(routeName == 'offline.event.produk.sesi') {
        var count = 0;
        var intervalId = null;
        var kodeBelow = 0;
        var harga_awal = $('#harga_awal').text().replaceAll(',', '')
        var kelipatan_harga = $('#kelipatan_harga').text().replaceAll(',', '')

        $('#start_lelang').on('click', function(){
            startTimer();
            $('#start_lelang').addClass('d-none');
            $('#stop_lelang').removeClass('d-none').removeAttr('disabled');
            $('.btn-peserta-lelang').removeAttr('disabled');
        });
        $('#stop_lelang').on('click', function(){
            stopTimer();
            $('#btn_finish_lelang').removeClass('d-none')
            $('.btn-peserta-lelang').attr('disabled', '');
            $('#start_lelang').attr('disabled', '');
            $('#stop_lelang').addClass('d-none').attr('disabled', '');
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
                    console.log(res)
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

        function startTimer() {
            intervalId = setInterval(function() {
                count++;
                var hours = ("0" + Math.floor(count / 3600)).slice(-2);
                var minutes = ("0" + Math.floor((count - (hours * 3600)) / 60)).slice(-2);
                var seconds = ("0" + (count - (hours * 3600) - (minutes * 60))).slice(-2);
                document.getElementById("time").innerHTML = hours + ":" + minutes + ":" + seconds;
            }, 1000);
        }

        function stopTimer() {
            clearInterval(intervalId);
        }

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
                        console.log(res)
                    },
                    error: function(err) {console.error(err)},
                })

                var hours = ("0" + Math.floor(count / 3600)).slice(-2);
                var minutes = ("0" + Math.floor((count - (hours * 3600)) / 60)).slice(-2);
                var seconds = ("0" + (count - (hours * 3600) - (minutes * 60))).slice(-2);

                if($('div.riwayat_penawaran').children('p').length == 1) {
                    $('.riwayat_penawaran').children('p').remove();
                    $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + $(this).data('kode') + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(harga_awal)).replaceAll('.', ',') + '</li></ul>');
                } else {
                    if($('div.riwayat_penawaran').children('ul').length == 0) {
                        $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + $(this).data('kode') + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(harga_awal)).replaceAll('.', ',') + '</li></ul>');
                    } else {
                        $('.riwayat_penawaran').children('ul.list-group').prepend('<li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + $(this).data('kode') + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(harga_awal)).replaceAll('.', ',') + '</li>');
                    }
                }

                harga_awal = parseInt(harga_awal) + parseInt(kelipatan_harga);
                $('#show_price').text((Intl.NumberFormat().format(harga_awal)).replaceAll('.', ','))
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
    if(routeName == 'administrasi.gudang.penerimaan.create') {
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
                    console.log(res);
                    $('.komoditas-satuan-ukuran').html(res.data.satuan_ukuran);
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
