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
            'day' => 'required',
            'date' => 'required|date',
            'groom_name' => 'required',
            'pride_father_name' => 'required',
            'address' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
        ];
    }
}
