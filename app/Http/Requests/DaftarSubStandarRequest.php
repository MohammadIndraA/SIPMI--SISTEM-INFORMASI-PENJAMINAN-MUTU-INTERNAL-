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
            'jenjang' => 'nullable|string',
            'jenis_perhitungan' => 'nullable|string',
            'isian_rumus' => 'nullable|string',

        ];
    }

    public function messages()
    {
        return [
            'nama_sub_standar.required' => 'Nama Sub Standar  harus diisi.',
            'nama_sub_standar.unique' => 'Nama Sub Standar  sudah ada.',
            'kategori' => 'Kategori Sub Standar  harus diisi.',
            'jenjang' => 'Jenjang Sub Standar  harus diisi.',
            'jenis_perhitungan' => 'Jenis Perhitungan Sub Standar  harus diisi.',
            'isian_rumus' => 'Isian Rumus Sub Standar  harus diisi.',
        ];
    }
}
