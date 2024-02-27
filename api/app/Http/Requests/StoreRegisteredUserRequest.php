<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules;
use App\Rules\TeenAgeCare;

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
            'birth_year'    => ['sometimes', 'numeric','between:1900,2100', new TeenAgeCare()],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'gender'        => ['sometimes', new Enum(\App\Enums\Citizen\Gender::class)],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()]
        ];
    }
}
