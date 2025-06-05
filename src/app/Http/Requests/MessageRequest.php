<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'body'=>['required', 'max:400'],
            'message_image'=>['nullable', 'regex:/^chat-img\/.*\.(jpeg|png)$/']
        ];
    }

    public function messages():array
    {
        return [
            'body.required'=>'本文を入力してください',
            'body.max'=>'本文は400文字以内で入力してください',
            'message_image.regex'=>'「.png」または「.jpeg」形式でアップロードしてください'
        ];
    }
}
