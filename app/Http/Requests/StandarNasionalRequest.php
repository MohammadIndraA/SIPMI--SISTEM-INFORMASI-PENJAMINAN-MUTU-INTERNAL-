<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class StandarNasionalRequest extends FormRequest
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
            'standar_nasional' => ['required', 'string', 'max:250', Rule::unique('standar_nasionals', 'standar_nasional')->ignore($request->id),],
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'standar_nasional.required' => 'Standar Nasional harus diisi.',
            'standar_nasional.string' => 'Standar Nasional harus berupa teks.',
            'standar_nasional.max' => 'Standar Nasional tidak boleh lebih dari 250 karakter.',
            'standar_nasional.unique' => 'Standar Nasional sudah ada.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
        ];
    }
}
