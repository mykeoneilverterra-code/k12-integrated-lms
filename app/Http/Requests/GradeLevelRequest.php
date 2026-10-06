<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GradeLevelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $gradeLevel = $this->route('grade_level');

        $uniqueLevel = Rule::unique(
            'grade_levels',
            'level'
        );

        if ($gradeLevel) {
            $uniqueLevel->ignore($gradeLevel->id);
        }

        return [
            'name' => [
                'required',
                'string',
                'max:50',
            ],

            'level' => [
                'required',
                'integer',
                'between:1,6',
                $uniqueLevel,
            ],

            'education_stage' => [
                'required',
                Rule::in([
                    'elementary',
                ]),
            ],
        ];
    }
}