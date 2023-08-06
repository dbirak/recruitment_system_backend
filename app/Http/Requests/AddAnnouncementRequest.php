<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAnnouncementRequest extends FormRequest
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
            'opis' => 'required|string|max:500',
            'obowiazki' => 'required|array|min:1',
            'obowiazki.*' => 'required|string|max:100',
            'wymagania' => 'required|array|min:1',
            'wymagania.*' => 'required|string|max:100',
            'oferta' => 'required|array|min:1',
            'oferta.*' => 'required|string|max:100',
            'data_zakonczenia' => 'required|date',
            'min_wynagrodzenie' => 'nullable|numeric|min:0',
            'max_wynagrodzenie' => 'nullable|numeric|min:0',
            'czas_pracy' => 'nullable|integer|min:1',
            'umowa' => 'required|integer|min:1',
            'kategoria' => 'required|integer|min:1',
            'czas_pracy' => 'required|integer|min:1',
            'typ_pracy' => 'required|integer|min:1',
            'etapy' => 'nullable|array',
            'etapy.*.module' => 'required|string|in:test,openTask,fileTask',
            'etapy.*.task.id' => 'required|integer',
            'etapy.*.task.name' => 'required|string',
        ];
    }
}
