<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionGradeRequest
    extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'score' => [
                'required',
                'numeric',
                'min:0',
            ],

            'feedback' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ];
    }
}