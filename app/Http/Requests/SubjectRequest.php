<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'code' => strtoupper(
                trim($this->code ?? '')
            ),

            'is_active' => $this->boolean(
                'is_active'
            ),
        ]);
    }

    public function rules(): array
    {
        $subject = $this->route('subject');

        $uniqueCode = Rule::unique(
            'subjects',
            'code'
        );

        if ($subject) {
            $uniqueCode->ignore($subject->id);
        }

        return [
            'code' => [
                'required',
                'string',
                'max:30',
                $uniqueCode,
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}