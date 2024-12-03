<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class PengaturanPeriodeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        return [
            'tahun_periode_id' => ['required', 'numeric'],
            'lembaga_akreditasi_id' => ['required', 'numeric'],
            'standar_nasional_id' => ['required', 'array'],
            'awal_periode_evaluasi_diri' => ['required', 'date_format:Y-m-d'],
            'akhir_periode_evaluasi_diri' => ['required', 'date_format:Y-m-d'],
            'awal_periode_desk_evaluasi' => ['required', 'date_format:Y-m-d'],
            'akhir_periode_desk_evaluasi' => ['required', 'date_format:Y-m-d'],
            'awal_periode_visitasi' => ['required', 'date_format:Y-m-d'],
            'akhir_periode_visitasi' => ['required', 'date_format:Y-m-d'],
        ];
    }
}
