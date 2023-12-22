<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenerimaanJaminanObligasiRequest extends FormRequest
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
            'penerbit' => ['required'],
            'kupon' => ['required'],
            'tipe_kupon' => ['required'],
            'nilai_nominal' => ['required'],
            'haircut' => ['required'],
            'nilai_tersedia' => ['required'],
            'tanggal_penerbitan' => ['required'],
            'tanggal_jatuh_tempo' => ['required'],
            'lokasi' => ['required'],
        ];
    }
}
