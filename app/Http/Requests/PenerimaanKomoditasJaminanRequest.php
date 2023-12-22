<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenerimaanKomoditasJaminanRequest extends FormRequest
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
            'komoditi' => ['required'],
            'kadaluarsa' => ['required'],
            'unit' => ['required'],
            'kuantitas' => ['required'],
            'nilai_perkiraan' => ['required'],
            'haircut' => ['required'],
            'nilai_penyesuaian' => ['required'],
            'lokasi' => ['required'],
        ];
    }
}
