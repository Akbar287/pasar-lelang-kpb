<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenerimaanJaminanSahamRequest extends FormRequest
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
            'kode_saham' => ['required'],
            'penerbit' => ['required'],
            'harga_saham' => ['required'],
            'lot' => ['required'],
            'nilai_saham' => ['required'],
            'haircut' => ['required'],
            'nilai_tersedia' => ['required'],
            'lokasi' => ['required'],
        ];
    }
}
