<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'content'=>['required', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'content.required'=>'商品コメントを入力してください',
            'content.max'=>'商品コメントは255文字以下で入力してください'
        ];
    }
}
