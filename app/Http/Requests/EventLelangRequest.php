<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventLelangRequest extends FormRequest
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
            'offline_profile_id' => ['required'],
            'event_kode' => ['required', 'max:32'],
            'nama_lelang' => ['required', 'max:128'],
            'tanggal_lelang' => ['required', 'date'],
            'lokasi' => ['required'],
            'ketua_lelang' => ['required', 'max:128'],
        ];
    }
}
