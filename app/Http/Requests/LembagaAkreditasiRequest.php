<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class LembagaAkreditasiRequest extends FormRequest
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
            'lembaga_akreditasi' => ['required', 'string', 'max:250', Rule::unique('lembaga_akreditasis', 'lembaga_akreditasi')->ignore($request->id),],
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'lembaga_akreditasi.required' => 'Lembaga akreditasi harus diisi.',
            'lembaga_akreditasi.unique' => 'Lembaga akreditasi sudah ada.',
            'lembaga_akreditasi.string' => 'Lembaga akreditasi harus berupa teks.',
        ];
    }
}
