<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreObservationRequest extends FormRequest
{

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if(! $this->user()){
            die("User not found"); // TODO: change to exception
        }

        $this->merge([
            'user_id' => $this->user()->id,
        ]);
    }

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
            'audio_param_1' => [''],
            'audio_param_2' => [''],
            'audio_param_3' => [''],
            'audio_param_4' => [''],
            'images' => [File::image()
                ->types(['jpg', 'png'])
                ->min(1024)
                ->max(12 * 1024)
                ->dimensions(Rule::dimensions()->maxWidth(1000)->maxHeight(500)),
            ],
            'sound_type' => [''],
            'sound_source' => [''],
            'sound_perception_enviroment' => [''],
            'comments' => [''],
            'user_id' => ['required','exists:users,id']
        ];
    }
}
