<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class DaftarStandarMutuRequest extends FormRequest
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
            'tahun_periode_id' => ['required', 'numeric', 'max:10'],
            'lembaga_akreditasi_id' => ['required', 'numeric', 'max:10'],
            'nama_standar_mutu' => [
                'required',
                Rule::unique('daftar_standar_mutus', 'nama_standar_mutu')->ignore($request->id),
            ],
            'deskripsi' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'tahun_periode_id.required' => 'Tahun Periode harus diisi.',
            'lembaga_akreditasi_id.required' => 'Lembaga Akreditasi harus diisi.',
            'nama_standar_mutu.required' => 'Nama Standar Mutu harus diisi.',
            'nama_standar_mutu.unique' => 'Nama Standar Mutu sudah ada.',
        ];
    }
}
