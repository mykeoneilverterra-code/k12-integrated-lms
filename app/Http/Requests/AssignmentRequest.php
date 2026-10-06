<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' =>
                $this->boolean(
                    'is_published'
                ),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'instructions' => [
                'nullable',
                'string',
            ],

            'total_points' => [
                'required',
                'numeric',
                'min:1',
                'max:10000',
            ],

            'due_at' => [
                'nullable',
                'date',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png',
                'max:10240',
            ],

            'is_published' => [
                'required',
                'boolean',
            ],
        ];
    }
}