<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'name' => 'required|string|max:250|unique:permissions,name'.(isset($this->permission->id) ? ',' . $this->permission->id : ''),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama permission harus diisi.',
            'name.string' => 'Nama permission harus berupa string.',
            'name.max' => 'Panjang nama permission tidak boleh lebih dari 250 karakter.',
            'name.unique' => 'Nama permission sudah ada, silahkan ganti dengan nama lain.',
        ];
    }
}
