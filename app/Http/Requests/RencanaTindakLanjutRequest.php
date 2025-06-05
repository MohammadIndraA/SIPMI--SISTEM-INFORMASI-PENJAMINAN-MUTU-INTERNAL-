<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RencanaTindakLanjutRequest extends FormRequest
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
            'root_cause' => 'required|string',
            'action_plan' => 'required|string',
            'Rekomendasi' => 'required|string',
            'person_in_charge' => 'required|string',
            'target_waktu_penyelesaian' => 'required|string',
            'poin_id' => 'required|exists:poin,id',
        ];
    }

    public function messages()
    {
        return [
            'root_cause.required' => 'Root Cause harus diisi.',
            'action_plan.required' => 'Action Plan harus diisi.',
            'Rekomendasi.required' => 'Rekomendasi harus diisi.',
            'person_in_charge.required' => 'Person In Charge harus diisi.',
            'target_waktu_penyelesaian.required' => 'Target Waktu Penyelesaian harus diisi.',
            'poin_id.required' => 'Poin harus diisi.',
        ];
    }
}
