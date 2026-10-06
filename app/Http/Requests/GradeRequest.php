<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quarter' => [
                'required',
                'integer',
                'between:1,4',
            ],

            'action' => [
                'required',
                Rule::in([
                    'draft',
                    'finalize',
                ]),
            ],

            'grades' => [
                'required',
                'array',
            ],

            'grades.*' => [
                'nullable',
                'numeric',
                'between:0,100',
            ],
        ];
    }
}