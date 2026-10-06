<?php

namespace App\Http\Requests;

use App\Models\Section;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $assignment = $this->route(
            'class_assignment'
        );

        $unique = Rule::unique(
            'class_subjects',
            'subject_id'
        )->where(
            fn ($query) =>
                $query->where(
                    'section_id',
                    $this->section_id
                )
        );

        if ($assignment) {
            $unique->ignore(
                $assignment->id
            );
        }

        return [
            'section_id' => [
                'required',
                'exists:sections,id',
            ],

            'subject_id' => [
                'required',
                'exists:subjects,id',
                $unique,
            ],

            'teacher_id' => [
                'nullable',
                'exists:teachers,id',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            $section = Section::with(
                'gradeLevel'
            )->find(
                $this->section_id
            );

            if (! $section) {
                return;
            }

            $allowed = $section
                ->gradeLevel
                ->subjects()
                ->whereKey(
                    $this->subject_id
                )
                ->exists();

            if (! $allowed) {
                $validator->errors()->add(
                    'subject_id',
                    'This subject is not included in the curriculum blueprint for this grade level.'
                );
            }
        });
    }
}