<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' =>
                $this->boolean(
                    'is_published'
                ),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'duration_minutes' => [
                'nullable',
                'integer',
                'min:1',
                'max:300',
            ],

            'opens_at' => [
                'nullable',
                'date',
            ],

            'closes_at' => [
                'nullable',
                'date',
                'after_or_equal:opens_at',
            ],

            'is_published' => [
                'required',
                'boolean',
            ],
        ];
    }
}