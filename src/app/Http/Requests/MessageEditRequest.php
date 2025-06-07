<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageEditRequest extends FormRequest
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
            'edit_body'=>['required', 'max:400'],
        ];
    }

    public function messages():array
    {
        return [
            'edit_body.required'=>'本文を入力してください',
            'edit_body.max'=>'本文は400文字以内で入力してください',
        ];
    }

}
