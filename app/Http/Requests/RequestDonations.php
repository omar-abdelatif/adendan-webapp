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
            'member_id'            => ['required', 'integer'],
            'amount'               => ['required', 'numeric'],
            'invoice_no'           => ['nullable', 'integer'],
            'donation_duration'    => ['required'],
            'donation_type'        => ['required'],
            'other_donation'       => ['nullable'],
            'donation_destination' => ['required']
        ];
    }
}
