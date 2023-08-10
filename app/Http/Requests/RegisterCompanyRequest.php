<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCompanyRequest extends FormRequest
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
            'imię' => 'required|string|max:30|regex:/^[a-zA-ZĄ-ŻĄąĆćĘęŁłŃńÓóŚśŹźŻż _-]{1,}$/',
            'nazwisko' => 'required|string|max:30|regex:/^[a-zA-ZĄ-ŻĄąĆćĘęŁłŃńÓóŚśŹźŻż _-]{1,}$/',
            'nazwa' => 'required|string|max:50|regex:/^[a-zA-ZĄ-ŻĄąĆćĘęŁłŃńÓóŚśŹźŻż. _-]{1,}$/',
            'email' => 'required|string|unique:users|email|max:30',
            'hasło' => 'required|string|min:8',
            'powtórz hasło' => 'required',
            //TO DO - add regex for numbers
            'ulica' => 'required|string|max:30',
            'kod pocztowy' => 'required|string|min:6|max:6|regex:/\d{2}-\d{3}/',
            'miasto' => 'required|string|max:30|regex:/^[a-zA-ZĄ-ŻĄąĆćĘęŁłŃńÓóŚśŹźŻż _-]{1,}$/',
            'krs' => 'required|string|max:10|min:10',
            'regon' => 'required|string|min:9|max:9',
            'nip' => 'required|string|min:10|max:10',
            'numer telefonu' => 'required|string|min:9|max:9',
            'województwo' => 'required|integer|exists:provinces,id',
        ];
    }
}
