<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subjects' => [
                'nullable',
                'array',
            ],

            'subjects.*' => [
                'integer',
                'exists:subjects,id',
            ],
        ];
    }
}