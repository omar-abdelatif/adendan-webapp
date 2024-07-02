<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TombRequest extends FormRequest
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
            'title' => 'required',
            'region' => 'required',
            'tomb_guard_name' => 'nullable',
            'tomb_guard_number' => 'nullable',
            'location' => 'nullable'
        ];
    }
}
