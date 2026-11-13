<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    // Only logged-in users can submit comments.
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    // Validate the comment body.
    public function rules(): array
    {
        return [
            'body' => [
                'required',
                'string',
                'min:3',
                'max:1000',
            ],
        ];
    }

    // Custom validation messages.
    public function messages(): array
    {
        return [
            'body.min' => 'Purok Genilla comments need at least 3 characters.',
        ];
    }
}
