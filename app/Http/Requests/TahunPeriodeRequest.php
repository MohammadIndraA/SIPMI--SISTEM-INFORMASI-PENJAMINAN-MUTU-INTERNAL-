<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class TahunPeriodeRequest extends FormRequest
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
            'tahun_periode' => [
                'required',
                'numeric',
                Rule::unique('tahun_periodes', 'tahun_periode')->ignore($request->id),
            ],
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'tahun_periode.required' => 'Tahun Periode harus diisi.',
            'tahun_periode.numeric' => 'Tahun Periode harus berupa angka.',
            'tahun_periode.unique' => 'Tahun Periode sudah ada.',
            'status.required' => 'Status harus diisi.',
        ];
    }
}
