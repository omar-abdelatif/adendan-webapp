<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MiscellaneousRequest extends FormRequest
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
            'amount' => ['required'],
            'invoice_img' => ['image', 'mimes:png,jpg,webp,jpeg', 'max:2048'],
            'category' => ['required'],
            'other_category' => ['nullable']
        ];
    }
}
