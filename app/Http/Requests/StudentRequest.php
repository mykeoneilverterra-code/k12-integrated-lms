<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $student = $this->route('student');

        $studentEmail = Rule::unique(
            'students',
            'email'
        );

        $userEmail = Rule::unique(
            'users',
            'email'
        );

        if ($student) {
            $studentEmail->ignore(
                $student->id
            );

            if ($student->user_id) {
                $userEmail->ignore(
                    $student->user_id
                );
            }
        }

        return [
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

            'birth_date' => [
                'required',
                'date',
                'before:today',
            ],

            'sex' => [
                'required',
                Rule::in([
                    'Male',
                    'Female',
                ]),
            ],

            'email' => [
                'nullable',
                'email',
                $studentEmail,
                $userEmail,
            ],

            'contact_number' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                    'transferred',
                ]),
            ],

            'password' => [
                $student
                    ? 'nullable'
                    : 'required',

                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }
}