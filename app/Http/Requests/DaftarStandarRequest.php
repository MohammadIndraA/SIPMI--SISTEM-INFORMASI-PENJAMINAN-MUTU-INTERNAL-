<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class DaftarStandarRequest extends FormRequest
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

         // Sanitasi input sebelum validasi
    $request->merge([
        'nama_standar' => strip_tags($request->nama_standar),
        'deskripsi' => strip_tags($request->deskripsi),
    ]);

        return [
            'nama_standar' => [
                'required',
                'regex:/^[^<>]*$/',
                Rule::unique('daftar_standars', 'nama_standar')->ignore($request->id),
            ],
            'deskripsi' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'nama_standar.required' => 'Nama Standar Mutu harus diisi.',
            'nama_standar.unique' => 'Nama Standar Mutu sudah ada.',
            'kategori.required' => 'Kategori Standar Mutu harus diisi.',
        ];
    }
}
