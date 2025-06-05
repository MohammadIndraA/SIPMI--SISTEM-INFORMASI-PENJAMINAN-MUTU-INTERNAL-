<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndikatorRequest extends FormRequest
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
            'sangat_kurang' => 'required|string',
            'kurang' => 'required|string',
            'cukup_baik' => 'required|string',
            'baik' => 'required|string',
            'sangat_baik' => 'required|string',
        ];
    }
}
