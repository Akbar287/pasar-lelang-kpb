<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengeluaranJaminanRequest extends FormRequest
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
            'informasi_akun_id' => ['required'],
            'jenis_pengeluaran_jaminan_id' => ['required'],
            'kode_transaksi' => ['required'],
            'tanggal' => ['required'],
        ];
    }
}
