<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenerimaanJaminanDepositoRequest extends FormRequest
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
            'no_sertifikat' => ['required'],
            'no_rekening' => ['required'],
            'tanggal_terbit' => ['required'],
            'tanggal_jatuh_tempo' => ['required'],
            'tanggal_valuta' => ['required'],
            'bank_penerbit' => ['required'],
            'nilai_nominal' => ['required'],
            'haircut' => ['required'],
            'nilai_tersedia' => ['required'],
        ];
    }
}
