<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekeningBankRequest extends FormRequest
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
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'nama_pemilik' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required'],
            'nilai_awal' => ['required'],
            'saldo' => ['required'],
        ];
    }
}
