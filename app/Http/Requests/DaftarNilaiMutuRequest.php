<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class daftarNilaiMutuRequest extends FormRequest
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
            'tahun_periode_id' => ['required', 'numeric', 'max:10'],
            'lembaga_akreditasi_id' => ['required', 'numeric', 'max:10'],
            'nilai_mutu' => ['required', 'max:10'],
            'keterangan' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Field ini harus diisi.',
            'max' => 'Field ini tidak boleh melebihi :max karakter.',
        ];
    }
}
