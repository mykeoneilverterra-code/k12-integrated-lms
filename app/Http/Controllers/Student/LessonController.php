<?php

namespace App\Http\Controllers\Student;

use App\Models\ClassSubject;
use App\Models\Lesson;

class LessonController extends BaseStudentController
{
    public function index(
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->accessibleSubject(
                $classSubject
            );

        $lessons =
            $classSubject
                ->lessons()
                ->where(
                    'is_published',
                    true
                )
                ->whereNotNull(
                    'published_at'
                )
                ->where(
                    'published_at',
                    '<=',
                    now()
                )
                ->latest(
                    'published_at'
                )
                ->paginate(15);

        return view(
            'student.lessons.index',
            compact(
                'classSubject',
                'lessons'
            )
        );
    }

    public function show(
        ClassSubject $classSubject,
        Lesson $lesson
    ) {
        $classSubject =
            $this->accessibleSubject(
                $classSubject
            );

        abort_unless(
            $lesson->class_subject_id
            === $classSubject->id &&
            $lesson->is_published,
            404
        );

        return view(
            'student.lessons.show',
            compact(
                'classSubject',
                'lesson'
            )
        );
    }
}