<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuktiPendukungRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'file_pendukung' => 'required|mimes:pdf|max:8048',
            'kategori_dokumen_id' => 'required|exists:kategori_dokumens,id',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama harus diisi.',
            'file_pendukung.required' => 'File pendukung wajib diunggah.',
            'kategori_dokumen_id.required' => 'Kategori dokumen harus dipilih.',
        ];
    }
}
