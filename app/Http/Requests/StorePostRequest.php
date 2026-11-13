<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    // Only users with an author profile can create posts.
    public function authorize(): bool
    {
        return $this->user()?->author()->exists() ?? false;
    }

    // Validate the new bulletin post.
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:120',
            ],

            'body' => [
                'required',
                'string',
                'min:20',
            ],

            'category' => [
                'required',
                Rule::in([
                    'Announcement',
                    'Health',
                    'Peace & Order',
                    'Ayuda',
                    'Events',
                ]),
            ],

            'tags' => [
                'required',
                'array',
                'min:1',
            ],

            'tags.*' => [
                'exists:tags,id',
            ],

            'is_published' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}

