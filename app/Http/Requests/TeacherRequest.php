<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teacher = $this->route('teacher');

        $employeeNumber = Rule::unique(
            'teachers',
            'employee_number'
        );

        $teacherEmail = Rule::unique(
            'teachers',
            'email'
        );

        $userEmail = Rule::unique(
            'users',
            'email'
        );

        if ($teacher) {
            $employeeNumber->ignore($teacher->id);

            $teacherEmail->ignore($teacher->id);

            if ($teacher->user_id) {
                $userEmail->ignore(
                    $teacher->user_id
                );
            }
        }

        return [
            'employee_number' => [
                'required',
                'string',
                'max:30',
                $employeeNumber,
            ],

            'first_name' => [
                'required',
                'string',
                'max:60',
            ],

            'middle_name' => [
                'nullable',
                'string',
                'max:60',
            ],

            'last_name' => [
                'required',
                'string',
                'max:60',
            ],

            'suffix' => [
                'nullable',
                'string',
                'max:20',
            ],

            'email' => [
                'required',
                'email',
                $teacherEmail,
                $userEmail,
            ],

            'contact_number' => [
                'nullable',
                'string',
                'max:30',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],

            'password' => [
                $teacher
                    ? 'nullable'
                    : 'required',

                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }
}