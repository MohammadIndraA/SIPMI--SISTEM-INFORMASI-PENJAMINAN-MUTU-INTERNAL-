<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class DaftarSubStandarRequest extends FormRequest
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
            'nama_sub_standar' => [
                'required',
                Rule::unique('daftar_sub_standars', 'nama_sub_standar')->ignore($request->id),
            ],
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string',
            'jenjang' => 'required',
            'jenis_perhitungan' => 'required',
            'isian_rumus' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'nama_sub_standar.required' => 'Nama Sub Standar  harus diisi.',
            'nama_sub_standar.unique' => 'Nama Sub Standar  sudah ada.',
            'kategori.required' => 'Kategori Sub Standar  harus diisi.',
            'jenjang.required' => 'Jenjang Sub Standar  harus diisi.',
            'jenis_perhitungan.required' => 'Jenis Perhitungan Sub Standar  harus diisi.',
            'isian_rumus.required' => 'Isian Rumus Sub Standar  harus diisi.',
        ];
    }
}
