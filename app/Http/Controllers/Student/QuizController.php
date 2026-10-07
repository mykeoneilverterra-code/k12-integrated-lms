<?php

namespace App\Http\Controllers\Student;

use App\Models\ClassSubject;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends BaseStudentController
{
    public function index(
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->accessibleSubject(
                $classSubject
            );

        $enrollment =
            $this->currentEnrollment();

        $quizzes =
            $classSubject
                ->quizzes()
                ->where(
                    'is_published',
                    true
                )
                ->withCount('questions')
                ->latest()
                ->paginate(15);

        $attempts =
            QuizAttempt::where(
                'enrollment_id',
                $enrollment->id
            )
                ->whereIn(
                    'quiz_id',
                    $quizzes
                        ->getCollection()
                        ->pluck('id')
                )
                ->get()
                ->keyBy('quiz_id');

        return view(
            'student.quizzes.index',
            compact(
                'classSubject',
                'quizzes',
                'attempts'
            )
        );
    }

    public function take(
        ClassSubject $classSubject,
        Quiz $quiz
    ) {
        $classSubject =
            $this->accessibleSubject(
                $classSubject
            );

        abort_unless(
            $quiz->class_subject_id
            === $classSubject->id &&
            $quiz->is_published,
            404
        );

        if (
            $quiz->opens_at &&
            now()->lessThan(
                $quiz->opens_at
            )
        ) {
            return back()->with(
                'error',
                'This quiz is not open yet.'
            );
        }

        if (
            $quiz->closes_at &&
            now()->greaterThan(
                $quiz->closes_at
            )
        ) {
            return back()->with(
                'error',
                'This quiz is already closed.'
            );
        }

        $enrollment =
            $this->currentEnrollment();

        $attempt =
            QuizAttempt::firstOrCreate(
                [
                    'quiz_id'
                        => $quiz->id,

                    'enrollment_id'
                        => $enrollment->id,
                ],
                [
                    'status'
                        => 'in_progress',

                    'started_at'
                        => now(),
                ]
            );

        if (
            $attempt->status
            === 'submitted'
        ) {
            return redirect()
                ->route(
                    'student.quizzes.result',
                    [
                        $classSubject,
                        $quiz
                    ]
                );
        }

        $quiz->load([
            'questions.choices'
                => function ($query) {
                    $query->select([
                        'id',
                        'quiz_question_id',
                        'choice_text',
                    ]);
                }
        ]);

        return view(
            'student.quizzes.take',
            compact(
                'classSubject',
                'quiz',
                'attempt'
            )
        );
    }

    public function submit(
        Request $request,
        ClassSubject $classSubject,
        Quiz $quiz
    ) {
        $classSubject =
            $this->accessibleSubject(
                $classSubject
            );

        abort_unless(
            $quiz->class_subject_id
            === $classSubject->id &&
            $quiz->is_published,
            404
        );

        $enrollment =
            $this->currentEnrollment();

        $attempt =
            QuizAttempt::where(
                'quiz_id',
                $quiz->id
            )
                ->where(
                    'enrollment_id',
                    $enrollment->id
                )
                ->firstOrFail();

        if (
            $attempt->status
            === 'submitted'
        ) {
            return redirect()
                ->route(
                    'student.quizzes.result',
                    [
                        $classSubject,
                        $quiz
                    ]
                );
        }

        $quiz->load(
            'questions.choices'
        );

        $answers =
            $request->input(
                'answers',
                []
            );

        $score = 0;

        DB::transaction(
            function () use (
                $quiz,
                $attempt,
                $answers,
                &$score
            ) {
                foreach (
                    $quiz->questions
                    as $question
                ) {
                    $selectedChoiceId =
                        $answers[
                            $question->id
                        ] ?? null;

                    $selectedChoice =
                        $question
                            ->choices
                            ->firstWhere(
                                'id',
                                (int)
                                $selectedChoiceId
                            );

                    $pointsAwarded = 0;

                    if (
                        $selectedChoice &&
                        $selectedChoice
                            ->is_correct
                    ) {
                        $pointsAwarded =
                            $question->points;

                        $score +=
                            $question->points;
                    }

                    QuizAnswer::updateOrCreate(
                        [
                            'quiz_attempt_id'
                                => $attempt->id,

                            'quiz_question_id'
                                => $question->id,
                        ],
                        [
                            'quiz_choice_id'
                                => $selectedChoice?->id,

                            'points_awarded'
                                => $pointsAwarded,
                        ]
                    );
                }

                $attempt->update([
                    'score' => $score,
                    'submitted_at' => now(),
                    'status' => 'submitted',
                ]);
            }
        );

        return redirect()
            ->route(
                'student.quizzes.result',
                [
                    $classSubject,
                    $quiz
                ]
            )
            ->with(
                'success',
                'Quiz submitted.'
            );
    }

    public function result(
        ClassSubject $classSubject,
        Quiz $quiz
    ) {
        $classSubject =
            $this->accessibleSubject(
                $classSubject
            );

        $enrollment =
            $this->currentEnrollment();

        $attempt =
            QuizAttempt::where(
                'quiz_id',
                $quiz->id
            )
                ->where(
                    'enrollment_id',
                    $enrollment->id
                )
                ->where(
                    'status',
                    'submitted'
                )
                ->firstOrFail();

        $totalPoints =
            $quiz
                ->questions()
                ->sum('points');

        return view(
            'student.quizzes.result',
            compact(
                'classSubject',
                'quiz',
                'attempt',
                'totalPoints'
            )
        );
    }
}