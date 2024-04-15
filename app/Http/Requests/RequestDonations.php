<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestDonations extends FormRequest
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
            'amount'               => ['required', 'numeric'],
            'member_id'            => ['required', 'integer'],
            'invoice_no'           => ['nullable'],
            'donation_type'        => ['required'],
            'other_donation'       => ['nullable'],
            'donation_category'    => ['nullable'],
        ];
    }
}
