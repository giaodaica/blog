<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdsRequest extends FormRequest
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
            'name' => ['required', 'string', 'regex:/^[\pL\s0-9]+$/u'],

            'slug' => 'required|alpha_dash'
        ];

    }
    public function messages()
    {
        return [
        'name.required' => 'Tên chiến dịch không được để trống',
        'name.string' => 'Tên chiến dịch chứa ký tự không hợp lệ',
        'name.regex' => 'Tên chiến dịch chứa ký tự không hợp lệ',
        'slug.required' => 'Slug không được để trống',
        'slug.alpha_dash' => 'Slug chỉ chấp nhận kí tự không dấu và phải có - ngăn-cách',
        ];
    }
}
