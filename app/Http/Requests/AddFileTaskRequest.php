<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddFileTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nazwa' => 'required|string|max:100',
            'czas' => 'required|integer|min:1|max:180',
            'opis' => 'required|string',
        ];
    }
}
