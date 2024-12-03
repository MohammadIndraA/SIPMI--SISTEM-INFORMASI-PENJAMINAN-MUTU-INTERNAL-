<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class ManajemenDokumenRequest extends FormRequest
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
            'nama_dokumen' => [
                'required',
                'string',
                Rule::unique('manajemen_dokumens', 'nama_dokumen')->ignore($request->id),
            ],
            'kategori_dokumen_id' => 'required',
            'file_dokumen' => $this->isMethod('post') // Wajib saat store, opsional saat update
            ?  'required|file|mimes:pdf|max:5048'
            : 'nullable|file|mimes:pdf|max:5048',
            
        ];
    }

    public function messages()
    {
        return [
            'nama_dokumen.unique' => 'Nama  Dokumen sudah ada',
            'nama_dokumen.required' => 'Nama Dokumen harus diisi',
            'nama_dokumen.string' => 'Nama Dokumen harus berupa string',
            'kategori_dokumen_id.required' => 'Kategori Dokumen harus diisi',
            'file_dokumen.required' => 'File Dokumen harus diisi',
            'file_dokumen.file' => 'File Dokumen harus berupa file',
            'file_dokumen.mimes' => 'File Dokumen harus berupa PDF',
            'file_dokumen.max' => 'File Dokumen maksimal 5MB',
        ];
    }
}
