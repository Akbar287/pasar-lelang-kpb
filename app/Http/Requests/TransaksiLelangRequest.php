<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiLelangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "jenis_opsi_pembayaran_lelang_id_penjual" => ['required'],
            "biaya_lain_lain_penjual" => ['required'],
            "jenis_opsi_pembayaran_lelang_id_pembeli" => ['required'],
            "biaya_lain_lain_pembeli" => ['required'],
            "kode_penyelesaian" => ['required'],
            "status_penyelesaian_id" => ['required'],
            "nomor_instruksi_keuangan_masuk" => ['required'],
            "nomor_faktur_keuangan_masuk" => ['required'],
            "tanggal_keuangan_masuk" => ['required'],
            "nomor_rekening_penyelenggara_keuangan_masuk" => ['required'],
            "status_keuangan_masuk" => ['required'],
            "nomor_instruksi_komoditas_masuk" => ['required'],
            "nomor_faktur_komoditas_masuk" => ['required'],
            "tanggal_komoditas_masuk" => ['required'],
            "status_komoditas_masuk" => ['required'],
            "nomor_instruksi_keuangan_keluar" => ['required'],
            "tanggal_keuangan_keluar" => ['required'],
            "nomor_rekening_penyelenggara_keuangan_keluar" => ['required'],
            "nomor_rekening_penjual_keuangan_keluar" => ['required'],
            "status_keuangan_keluar" => ['required'],
            "nomor_instruksi_komoditas_keluar" => ['required'],
            "tanggal_komoditas_keluar" => ['required'],
            "status_komoditas_keluar" => ['required'],
        ];
    }
}
