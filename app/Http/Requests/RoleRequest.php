<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|string|max:250|unique:roles,name' . (isset($this->role->id) ? ',' . $this->role->id : ''),
            'permissions' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama role harus diisi.',
            'name.string' => 'Nama role harus berupa string.',
            'name.max' => 'Panjang nama role tidak boleh lebih dari 250 karakter.',
            'name.unique' => 'Nama role sudah ada, silahkan ganti dengan nama lain.',
            'permissions.required' => 'Pilih minimal satu permission.', 
        ];
    }
}
