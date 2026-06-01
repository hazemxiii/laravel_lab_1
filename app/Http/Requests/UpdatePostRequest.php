<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $postId = $this->route('id');

        return [
            'title' => ['required', 'string', 'min:3', 'max:255', Rule::unique('posts', 'title')->ignore($postId)],
            'body'  => ['required', 'string', 'min:10'],
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'A title is required.',
            'title.min'      => 'The title must be at least 3 characters.',
            'title.max'      => 'The title may not exceed 255 characters.',
            'title.unique'   => 'A post with this title already exists.',
            'body.required'  => 'The post body is required.',
            'body.min'       => 'The body must be at least 10 characters.',
        ];
    }
}
