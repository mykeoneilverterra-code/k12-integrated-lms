<?php

namespace App\Http\Requests;

use App\Models\Section;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $enrollment = $this->route(
            'enrollment'
        );

        $uniqueEnrollment = Rule::unique(
            'enrollments',
            'student_id'
        )->where(
            fn ($query) =>
                $query->where(
                    'school_year_id',
                    $this->school_year_id
                )
        );

        if ($enrollment) {
            $uniqueEnrollment->ignore(
                $enrollment->id
            );
        }

        return [
            'student_id' => [
                'required',
                'exists:students,id',
                $uniqueEnrollment,
            ],

            'school_year_id' => [
                'required',
                'exists:school_years,id',
            ],

            'section_id' => [
                'required',
                'exists:sections,id',
            ],

            'status' => [
                'required',
                Rule::in([
                    'enrolled',
                    'passed',
                    'retained',
                    'transferred',
                    'dropped',
                ]),
            ],

            'enrolled_at' => [
                'nullable',
                'date',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            $section = Section::find(
                $this->section_id
            );

            if (
                $section &&
                (int) $section->school_year_id !==
                (int) $this->school_year_id
            ) {
                $validator->errors()->add(
                    'section_id',
                    'The selected section does not belong to the selected school year.'
                );
            }
        });
    }
}