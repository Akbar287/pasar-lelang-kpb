<?php

namespace App\Http\Helper;

use App\Models\PerjanjianJualBeliPasal;
use Barryvdh\DomPDF\Facade\Pdf;

class Helper
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public static function print_laporan_jaminan($data, $member, $date)
    {
        $logo = public_path() . '/images/e-kpb.png';
        $pdf = PDF::setPaper('a4')->loadView('laporan/print/jaminan', compact('data', 'member', 'date', 'logo'));
        // download PDF file with download method
        return $pdf->stream('jaminan-lelang-' . $member . '.pdf');
    }

    public static function print_laporan_daftar_anggota($chooser, $member, $lembaga, $status, $filterStatus, $statusList, $statusCount)
    {
        $logo = public_path() . '/images/e-kpb.png';
        $pdf = PDF::setPaper('a4')->loadView('laporan/print/daftar_anggota', compact('chooser', 'member', 'lembaga', 'status', 'logo', 'filterStatus', 'statusList', 'statusCount'));
        // download PDF file with download method
        return $pdf->stream('daftar-anggota.pdf');
    }

    public static function print_transaksi_lelang($member, $data, $date)
    {
        $logo = public_path() . '/images/e-kpb.png';
        $pdf = PDF::setPaper('a4')->loadView('laporan/print/transaksi_lelang', compact('member', 'data', 'date', 'logo'));
        // download PDF file with download method
        return $pdf->stream('transaksi_lelang.pdf');
    }

    public static function print_lelang($event, $tgl)
    {
        $logo = public_path() . '/images/e-kpb.png';
        $pdf = PDF::setPaper('a4')->loadView('laporan/print/lelang', compact('event', 'logo', 'tgl'));

        // download PDF file with download method
        return $pdf->stream('lelang.pdf');
    }

    public static function print_event_lelang($data)
    {
        $logo = public_path() . '/images/e-kpb.png';
        $pdf = PDF::setPaper('a4')->loadView('laporan/print/event_lelang', compact('data', 'logo'));
        // download PDF file with download method
        return $pdf->stream('event_lelang.pdf');
    }

    public static function print_transaksi_bank($member, $data, $jenisTransaksi, $date)
    {
        $logo = public_path() . '/images/e-kpb.png';
        $pdf = PDF::setPaper('a4')->loadView('laporan/print/transaksi_bank', compact('member', 'data', 'jenisTransaksi', 'date', 'logo'));
        // download PDF file with download method
        return $pdf->stream('transaksi_bank.pdf');
    }
    public static function print_perjanjian_jual_beli($penjual, $pembeli, $lelang, $event = null)
    {
        $logo = public_path() . '/images/e-kpb.png';
        $pasal = PerjanjianJualBeliPasal::orderBy('key', 'asc')->get();
        $pdf = PDF::setPaper('a4')->loadView('laporan/print/perjanjian_jual_beli', compact('penjual', 'pembeli', 'lelang', 'event', 'logo', 'pasal'));
        // download PDF file with download method
        return $pdf->stream('perjanjian_jual_beli.pdf');
    }

    public static function reformatDate($date)
    {
        $date = explode('-', $date);

        return $date['2'] . ' ' . self::monthParse($date['1']) . ' ' . $date['0'];
    }

    public static function show_komoditi_member_sesi($event, $penjual)
    {
        $logo = public_path() . '/images/e-kpb.png';
        $pdf = PDF::setPaper('a4')->loadView('laporan/print/laporan_peserta_komoditas', compact('penjual', 'event'));
        // download PDF file with download method
        return $pdf->stream('laporan_peserta_komoditas.pdf');
    }

    public static function monthParse($month)
    {
        $month = intval($month);
        if ($month == 1) {
            return 'Januari';
        }
        if ($month == 2) {
            return 'Februari';
        }
        if ($month == 3) {
            return 'Maret';
        }
        if ($month == 4) {
            return 'April';
        }
        if ($month == 5) {
            return 'Mei';
        }
        if ($month == 6) {
            return 'Juni';
        }
        if ($month == 7) {
            return 'Juli';
        }
        if ($month == 8) {
            return 'Agustus';
        }
        if ($month == 9) {
            return 'September';
        }
        if ($month == 10) {
            return 'Oktober';
        }
        if ($month == 11) {
            return 'November';
        }
        if ($month == 12) {
            return 'Desember';
        }
        return null;
    }
}
