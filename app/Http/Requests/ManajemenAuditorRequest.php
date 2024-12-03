<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ManajemenAuditorRequest extends FormRequest
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
            'nama_assesor' => ['required', 'string', 'max:250'],
            'gelar_awal' => ['required', 'string', 'max:250'],
            'gelar_akhir' => ['required', 'string', 'max:250'],
            'nik' => ['required', 'numeric', 'digits:16', Rule::unique('manajemen_auditors', 'nik')->ignore($request->id),],
            'lembaga_akreditasi_id' => ['required', 'numeric'],
            'jenis_kelamin' => ['required'],
            'instansi' => ['required', 'string'],
            'jabatan' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'nama_assesor.required' => 'Nama harus diisi',
            'gelar_awal.required' => 'Gelar harus diisi',
            'gelar_akhir.required' => 'Gelar harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.numeric' => 'NIK harus berupa angka',
            'nik.max' => 'NIK maksimal 16 angka',
            'nik.unique' => 'NIK sudah ada',
            'lembaga_akreditasi_id.required' => 'Lembaga Akreditasi harus diisi',
            'lembaga_akreditasi_id.numeric' => 'Lembaga Akreditasi harus berupa angka',
            'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
            'instansi.required' => 'Instansi harus diisi',
            'jabatan.required' => 'Jabatan harus diisi',
        ];
    }

}
