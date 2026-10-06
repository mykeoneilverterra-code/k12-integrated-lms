<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attendance_date' => [
                'required',
                'date',
            ],

            'attendance' => [
                'required',
                'array',
            ],

            'attendance.*' => [
                'required',
                Rule::in([
                    'present',
                    'absent',
                    'late',
                    'excused',
                ]),
            ],
        ];
    }
}