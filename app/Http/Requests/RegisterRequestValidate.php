<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequestValidate extends FormRequest
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
            'name'=> 'required|string|max:30',
            'email' => 'required|unique:users,email|string',
            'password' => 'required|min:6|string|confirmed',
            'phone' => [
                'required',
                'string',
                'regex:/^(\\+84\\d{9}|0\\d{9})$/'
            ],
            'role' => 'in:admin,author,reader',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
