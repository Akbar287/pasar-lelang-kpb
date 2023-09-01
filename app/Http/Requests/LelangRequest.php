<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LelangRequest extends FormRequest
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
            'jenis_perdagangan_id' => ['required'],
            'jenis_inisiasi_id' => ['required'],
            'jenis_harga_id' => ['required'],
            'kontrak_id' => ['required'],
            'nomor_lelang' => ['required', 'max:32'],
            'asal_komoditas' => ['required', 'max:128'],
            'spesifikasi_produk' => ['required'],
            'kuantitas' => ['required'],
            'kemasan' => ['required', 'max:128'],
            'lokasi_penyerahan' => ['required'],
            'harga_awal' => ['required'],
            'kelipatan_penawaran' => ['required'],
        ];
    }
}
