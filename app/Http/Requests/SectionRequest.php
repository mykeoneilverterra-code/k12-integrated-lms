<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $section = $this->route('section');

        $uniqueName = Rule::unique(
            'sections',
            'name'
        )->where(
            fn ($query) =>
                $query
                    ->where(
                        'school_year_id',
                        $this->school_year_id
                    )
                    ->where(
                        'grade_level_id',
                        $this->grade_level_id
                    )
        );

        if ($section) {
            $uniqueName->ignore($section->id);
        }

        return [
            'school_year_id' => [
                'required',
                'exists:school_years,id',
            ],

            'grade_level_id' => [
                'required',
                'exists:grade_levels,id',
            ],

            'adviser_teacher_id' => [
                'nullable',
                'exists:teachers,id',
            ],

            'name' => [
                'required',
                'string',
                'max:80',
                $uniqueName,
            ],
        ];
    }
}