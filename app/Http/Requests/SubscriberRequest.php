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
            'img' => 'image|max:2048|mimes:png,webp,jpg,jpeg',
            'job' => 'required|string',
            'ssn' => 'required|max:14',
            'name' => 'required|string',
            'id_img' => 'image|max:2048|mimes:png,webp,jpg,jpeg',
            'job_tel' => 'required',
            'address' => 'required|string',
            'home_tel' => 'required',
            'nickname' => 'required|string',
            'member_id' => 'required|string',
            'birthdate' => 'required|date',
            'mobile_no' => 'required',
            'job_address' => 'required|string',
            'martial_status' => 'required|string',
            'membership_type' => 'required|string',
            'job_destination' => 'required',
            'qualification_date' => 'required|date',
            'educational_qualification' => 'required|string',
        ];
    }
}
