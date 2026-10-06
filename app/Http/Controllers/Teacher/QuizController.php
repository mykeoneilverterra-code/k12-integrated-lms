<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\QuizRequest;
use App\Models\ClassSubject;
use App\Models\Quiz;

class QuizController
    extends BaseTeacherController
{
    public function index(
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $quizzes =
            $classSubject
                ->quizzes()
                ->withCount([
                    'questions',
                    'attempts',
                ])
                ->latest()
                ->paginate(15);

        return view(
            'teacher.quizzes.index',
            compact(
                'classSubject',
                'quizzes'
            )
        );
    }

    public function create(
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        return view(
            'teacher.quizzes.form',
            compact('classSubject')
        );
    }

    public function store(
        QuizRequest $request,
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $this->ensureEditable(
            $classSubject
        );

        $data =
            $request->validated();

        $data['class_subject_id'] =
            $classSubject->id;

        $data['teacher_id'] =
            $this
                ->currentTeacher()
                ->id;

        $data['published_at'] =
            $data['is_published']
            ? now()
            : null;

        $quiz =
            Quiz::create($data);

        return redirect()
            ->route(
                'teacher.quizzes.show',
                [
                    $classSubject,
                    $quiz
                ]
            )
            ->with(
                'success',
                'Quiz created. Add questions below.'
            );
    }

    public function show(
        ClassSubject $classSubject,
        Quiz $quiz
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        abort_unless(
            $quiz->class_subject_id
            === $classSubject->id,
            404
        );

        $quiz->load(
            'questions.choices'
        );

        return view(
            'teacher.quizzes.show',
            compact(
                'classSubject',
                'quiz'
            )
        );
    }

    public function edit(
        ClassSubject $classSubject,
        Quiz $quiz
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        abort_unless(
            $quiz->class_subject_id
            === $classSubject->id,
            404
        );

        return view(
            'teacher.quizzes.form',
            compact(
                'classSubject',
                'quiz'
            )
        );
    }

    public function update(
        QuizRequest $request,
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

        $data =
            $request->validated();

        $data['published_at'] =
            $data['is_published']
            ? (
                $quiz->published_at
                ?? now()
            )
            : null;

        $quiz->update($data);

        return redirect()
            ->route(
                'teacher.quizzes.index',
                $classSubject
            )
            ->with(
                'success',
                'Quiz updated.'
            );
    }

    public function destroy(
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

        if (
            $quiz
                ->attempts()
                ->exists()
        ) {
            return back()->with(
                'error',
                'Quiz already has attempts.'
            );
        }

        $quiz->delete();

        return back()->with(
            'success',
            'Quiz deleted.'
        );
    }
}