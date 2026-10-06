<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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

            'description' => [
                'nullable',
                'string',
            ],

            'video_url' => [
                'nullable',
                'url',
                'max:1000',
            ],

            'file' => [
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