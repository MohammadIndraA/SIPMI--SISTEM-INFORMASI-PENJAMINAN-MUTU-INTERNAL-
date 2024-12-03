<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
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
        // Ambil ID dari request jika ada (digunakan untuk pengecekan unik saat update)
        $userId = $userId = $request->input('id'); // Sesuaikan nama parameter jika berbeda

            return [
                'name' => 'required|string|min:3|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($userId), // Abaikan email user ini saat update
                ],
                'password' => $this->isMethod('post') // Wajib saat store, opsional saat update
                    ? 'required|string|min:8'
                    : 'nullable|string|min:8',
            ];
        }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password tidak boleh kosong.',
        ];
    }

}
