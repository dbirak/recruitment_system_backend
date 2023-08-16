<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchAnnouncementRequest extends FormRequest
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
            "nazwa" => "min:0|max:100",
            "kategoria" => "integer|min:0",
            "umowa" => "array|nullable",
            "umowa.*" => "integer|min:1",
            "min_wynagrodzenie" => "nullable|numeric|min:0",
            "max_wynagrodzenie" => "nullable|numeric|min:0",
            "typ_wynagrodzenia" => "integer|min:0",
            "czas_pracy" => "array|nullable",   
            "czas_pracy.*" => "integer|min:1",
            "typ_pracy" => "array|nullable",
            "typ_pracy.*" => "integer|min:1"
        ];
    }
}
