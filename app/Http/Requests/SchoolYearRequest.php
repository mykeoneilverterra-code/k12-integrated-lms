<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $schoolYear = $this->route('school_year');

        $uniqueName = Rule::unique(
            'school_years',
            'name'
        );

        if ($schoolYear) {
            $uniqueName->ignore($schoolYear->id);
        }

        return [
            'name' => [
                'required',
                'string',
                'max:20',
                $uniqueName,
            ],

            'starts_on' => [
                'nullable',
                'date',
            ],

            'ends_on' => [
                'nullable',
                'date',
                'after_or_equal:starts_on',
            ],

            'status' => [
                'required',
                Rule::in([
                    'upcoming',
                    'active',
                    'closed',
                ]),
            ],
        ];
    }
}