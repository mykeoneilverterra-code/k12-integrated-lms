<?php

namespace App\Http\Controllers\Teacher;

use App\Models\ClassSubject;

class ClassController
    extends BaseTeacherController
{
    public function index()
    {
        $teacher =
            $this->currentTeacher();

        $classes =
            ClassSubject::with([
                'section.gradeLevel',
                'section.schoolYear',
                'subject',
            ])
                ->withCount([
                    'enrollments as students_count'
                    => fn ($query) =>
                        $query->where(
                            'status',
                            'enrolled'
                        ),
                ])
                ->where(
                    'teacher_id',
                    $teacher->id
                )
                ->get();

        return view(
            'teacher.classes.index',
            compact(
                'teacher',
                'classes'
            )
        );
    }

    public function show(
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $classSubject->load([
            'section.gradeLevel',
            'section.schoolYear',
            'subject',
        ]);

        $studentCount =
            $classSubject
                ->enrollments()
                ->where(
                    'status',
                    'enrolled'
                )
                ->count();

        $lessonCount =
            $classSubject
                ->lessons()
                ->count();

        $assignmentCount =
            $classSubject
                ->assignments()
                ->count();

        $quizCount =
            $classSubject
                ->quizzes()
                ->count();

        return view(
            'teacher.classes.show',
            compact(
                'classSubject',
                'studentCount',
                'lessonCount',
                'assignmentCount',
                'quizCount'
            )
        );
    }

    public function students(
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $classSubject->load([
            'section.gradeLevel',
            'subject',
        ]);

        $enrollments =
            $classSubject
                ->enrollments()
                ->with('student')
                ->where(
                    'status',
                    'enrolled'
                )
                ->orderBy('id')
                ->paginate(25);

        return view(
            'teacher.classes.students',
            compact(
                'classSubject',
                'enrollments'
            )
        );
    }
}