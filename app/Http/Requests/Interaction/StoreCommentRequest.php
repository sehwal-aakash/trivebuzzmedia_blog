<?php

namespace App\Http\Requests\Interaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_id' => ['required', 'exists:posts,id'],
            'content' => ['required', 'string', 'max:1000'],
            'guest_name' => ['nullable', 'required_without:user_id', 'string', 'max:255'],
            'guest_email' => ['nullable', 'required_without:user_id', 'email', 'max:255'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ];
    }
}
