<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'profile_image'=>['nullable', 'regex:/^profile-img\/.*\.(jpeg|png)$/'],
            'postal_code'=>['required', 'regex:/^\d{3}-\d{4}$/'],
            'address'=>['required'],
            'building'=>['nullable']
        ];
    }

    public function messages(): array
    {
        return [
            'profile_image.regex'=>'「.png」または「.jpeg」形式でアップロードしてください',
            'postal_code.required'=>'郵便番号を入力してください',
            'postal_code.regex'=>'郵便番号はハイフンを含んだ８文字で入力してください',
            'address.required'=>'住所を入力してください'
        ];
    }
}
