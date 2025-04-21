<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequestValidate extends FormRequest
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
            'name'=> 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'role' => 'in:admin,author,reader',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
