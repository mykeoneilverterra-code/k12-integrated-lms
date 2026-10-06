<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\QuizQuestionRequest;
use App\Models\ClassSubject;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\DB;

class QuizQuestionController
    extends BaseTeacherController
{
    public function store(
        QuizQuestionRequest $request,
        ClassSubject $classSubject,
        Quiz $quiz
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $this->ensureEditable(
            $classSubject
        );

        abort_unless(
            $quiz->class_subject_id
            === $classSubject->id,
            404
        );

        DB::transaction(
            function () use (
                $request,
                $quiz
            ) {
                $data =
                    $request->validated();

                $question =
                    $quiz
                        ->questions()
                        ->create([
                            'question_text'
                                =>
                                $data[
                                    'question_text'
                                ],

                            'type' =>
                                $data['type'],

                            'points' =>
                                $data[
                                    'points'
                                ],
                        ]);

                foreach (
                    $data['choices']
                    as $index => $choice
                ) {
                    $question
                        ->choices()
                        ->create([
                            'choice_text'
                                => $choice,

                            'is_correct'
                                =>
                                $index
                                ===
                                (int)
                                $data[
                                    'correct_choice'
                                ],
                        ]);
                }
            }
        );

        return back()->with(
            'success',
            'Question added.'
        );
    }

    public function destroy(
        ClassSubject $classSubject,
        Quiz $quiz,
        QuizQuestion $question
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $this->ensureEditable(
            $classSubject
        );

        abort_unless(
            $quiz->class_subject_id
            === $classSubject->id,
            404
        );

        abort_unless(
            $question->quiz_id
            === $quiz->id,
            404
        );

        if (
            $quiz
                ->attempts()
                ->exists()
        ) {
            return back()->with(
                'error',
                'Questions cannot be removed after students have attempted the quiz.'
            );
        }

        $question->delete();

        return back()->with(
            'success',
            'Question removed.'
        );
    }
}