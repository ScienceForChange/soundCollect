<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules;

class StoreRegisteredUserRequest extends FormRequest
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
            'name'          => ['required', 'string', 'min:3','max:100'],
            'birth_year'    => ['required', 'numeric'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'gender'        => ['required', new Enum(\App\Enums\Citizen\Gender::class)],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()]
        ];
    }
}
