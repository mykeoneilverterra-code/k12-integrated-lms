<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_text' => [
                'required',
                'string',
            ],

            'type' => [
                'required',
                Rule::in([
                    'multiple_choice',
                    'true_false',
                ]),
            ],

            'points' => [
                'required',
                'numeric',
                'min:0.5',
                'max:100',
            ],

            'choices' => [
                'required',
                'array',
                'min:2',
            ],

            'choices.*' => [
                'required',
                'string',
                'max:500',
            ],

            'correct_choice' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }

    public function withValidator(
        $validator
    ): void {
        $validator->after(
            function ($validator) {

                $choices =
                    $this->input(
                        'choices',
                        []
                    );

                $correct =
                    (int) $this->input(
                        'correct_choice'
                    );

                if (
                    ! array_key_exists(
                        $correct,
                        $choices
                    )
                ) {
                    $validator
                        ->errors()
                        ->add(
                            'correct_choice',
                            'Select a valid correct answer.'
                        );
                }
            }
        );
    }
}