<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeddingRequest extends FormRequest
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
            'day' => 'nullable',
            'date' => 'nullable|date',
            'groom_name' => 'nullable',
            'pride_father_name' => 'nullable',
            'address' => 'nullable',
            'from_time' => 'nullable',
            'to_time' => 'nullable',
        ];
    }
}
