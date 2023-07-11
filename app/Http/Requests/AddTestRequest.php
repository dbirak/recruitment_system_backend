<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTestRequest extends FormRequest
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
            'pytania' => 'required|array',
            'pytania.*.pytanie' => 'required|string|max:200',
            'pytania.*.odpowiedzi' => 'required|array',
            'pytania.*.odpowiedzi.*.odpowiedz' => 'required|string|max:200',
            'pytania.*.odpowiedzi.*.poprawna' => 'required|boolean',
            'nazwa' => 'required|string|max:100',
            'czas' => 'required|integer|min:1|max:180',
        ];
    }
}
