<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class KategoriDokumenRequest extends FormRequest
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
            'kategori' => [
                'required',
                'string',
                Rule::unique('kategori_dokumens', 'kategori')->ignore($request->id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'kategori.unique' => 'Kategori Dokumen sudah ada',
            'kategori.required' => 'Kategori Dokumen harus diisi',
            'kategori.string' => 'Kategori Dokumen harus berupa string',
        ];
    }
}
