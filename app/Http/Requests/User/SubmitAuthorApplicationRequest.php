<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAuthorApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'bio' => ['required', 'string', 'min:50', 'max:1000'],
            'portfolio_links' => ['nullable', 'array'],
            'portfolio_links.*' => ['nullable', 'url'],
        ];
    }
}
