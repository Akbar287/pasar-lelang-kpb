<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengaturanKontrakRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'penyelenggara_pasar_lelang_id' => ['required'],
            'mutu_id' => ['required'],
            'komoditas_id' => ['required'],
            'informasi_akun_id' => ['required'],
            'jenis_perdagangan_id' => ['required'],
            'simbol' => ['required'],
            'minimum_transaksi' => ['required'],
            'maksimum_transaksi' => ['required'],
            'fluktuasi_harga_harian' => ['required'],
            'premium' => ['required'],
            'diskon' => ['required'],
            'jatuh_tempo_t_plus' => ['required'],
            'tanggal_aktif' => ['required'],
            'tanggal_berakhir' => ['required'],
            'jaminan_lelang' => ['required'],
            'denda' => ['required'],
            'fee_penjual' => ['required'],
            'fee_pembeli' => ['required'],
        ];
    }
}
