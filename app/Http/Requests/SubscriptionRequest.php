<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
            'period' => 'nullable',
            'delays' => 'nullable|numeric',
            'pay_date' => 'required|date',
            'member_id' => 'required',
            'invoice_no' => 'required',
            'payment_type' => 'required',
            'delays_period' => 'nullable',
            'subscription_cost' => 'nullable|numeric',
        ];
    }
}
