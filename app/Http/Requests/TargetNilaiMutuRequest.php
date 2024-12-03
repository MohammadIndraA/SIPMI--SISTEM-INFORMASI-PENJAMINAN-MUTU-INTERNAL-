<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class TargetNilaiMutuRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'fakultas_prodi_id' => ['required', 'numeric', 'max:10'],
            'tahun_periode_id' => ['required', 'numeric', 'max:10'],
            'lembaga_akreditasi_id' => ['required', 'numeric', 'max:10'],
            'target_nilai_mutu' => ['required', 'max:10'],
            'keterangan' => 'nullable|string',
        ];
    }
}
