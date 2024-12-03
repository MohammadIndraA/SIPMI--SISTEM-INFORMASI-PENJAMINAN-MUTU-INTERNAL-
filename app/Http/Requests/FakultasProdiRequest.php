<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class FakultasProdiRequest extends FormRequest
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
            'fakultas_prodi' => [
                'required',
                'string',
                'max:250',
                Rule::unique('fakultas_prodis', 'fakultas_prodi')->ignore($request->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'fakultas_prodi.required' => 'Fakultas Prodi harus diisi.',
            'fakultas_prodi.string' => 'Fakultas Prodi harus berupa teks.',
            'fakultas_prodi.max' => 'Fakultas Prodi tidak boleh lebih dari 250 karakter.',
            'fakultas_prodi.unique' => 'Fakultas Prodi sudah ada.',
        ];
    }
}
