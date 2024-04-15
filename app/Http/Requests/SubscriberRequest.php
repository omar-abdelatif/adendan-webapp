<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberRequest extends FormRequest
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
            'img' => 'nullable|image|max:2048|mimes:png,webp,jpg,jpeg',
            'job' => 'nullable|string',
            'ssn' => 'required|max:14',
            'name' => 'required|string',
            'id_img' => 'nullable|image|max:2048|mimes:png,webp,jpg,jpeg',
            'job_tel' => 'nullable',
            'address' => 'nullable|string',
            'home_tel' => 'nullable',
            'nickname' => 'nullable|string',
            'member_id' => 'required|string',
            'birthdate' => 'nullable|date',
            'mobile_no' => 'required',
            'job_address' => 'nullable|string',
            'martial_status' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'job_destination' => 'nullable',
            'qualification_date' => 'nullable|date',
            'educational_qualification' => 'nullable|string',
        ];
    }
}
