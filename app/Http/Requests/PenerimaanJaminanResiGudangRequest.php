<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenerimaanJaminanResiGudangRequest extends FormRequest
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
            'jenis' => ['required'],
            'pemilik_barang' => ['required'],
            'pemegang_resi_gudang' => ['required'],
            'no_penerbitan' => ['required'],
            'nama_resi_gudang' => ['required'],
            'nilai_resi_gudang' => ['required'],
            'haircut' => ['required'],
            'nilai_tersedia' => ['required'],
            'tanggal_penerbitan' => ['required'],
            'tanggal_jatuh_tempo' => ['required'],
        ];
    }
}
