<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProfileRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'localization' => 'required|json',
            'street' => 'required|string|max:50', 
            'post_code' => 'required|string|min:6|max:6|regex:/\d{2}-\d{3}/',
            'city' => 'required|string|max:30|regex:/^[a-zA-ZĄ-ŻĄąĆćĘęŁłŃńÓóŚśŹźŻż _-]{1,}$/', 
            'phone_number' => 'required|string|min:9|max:9',
            'contact_email' => 'nullable|string|max:30',
            'krs' => 'required|string|max:10|min:10',
            'nip' => 'required|string|min:10|max:10',
            'avatar' => 'mimes:jpeg,png,gif,bmp,jpg|max:4096',
            'background_image' => 'mimes:jpeg,png,gif,bmp,jpg|max:4096' 
        ];
    }
}
