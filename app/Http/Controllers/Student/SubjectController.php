<?php

namespace App\Http\Controllers\Student;

use App\Models\ClassSubject;

class SubjectController extends BaseStudentController
{
    public function index()
    {
        $enrollment =
            $this->currentEnrollment();

        $subjects =
            ClassSubject::with([
                'subject',
                'teacher',
                'section.gradeLevel',
            ])
                ->where(
                    'section_id',
                    $enrollment->section_id
                )
                ->get();

        return view(
            'student.subjects.index',
            compact(
                'subjects',
                'enrollment'
            )
        );
    }

    public function show(
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->accessibleSubject(
                $classSubject
            );

        $classSubject->load([
            'subject',
            'teacher',
            'section.gradeLevel',
        ]);

        $lessonCount =
            $classSubject
                ->lessons()
                ->where(
                    'is_published',
                    true
                )
                ->count();

        $assignmentCount =
            $classSubject
                ->assignments()
                ->where(
                    'is_published',
                    true
                )
                ->count();

        $quizCount =
            $classSubject
                ->quizzes()
                ->where(
                    'is_published',
                    true
                )
                ->count();

        return view(
            'student.subjects.show',
            compact(
                'classSubject',
                'lessonCount',
                'assignmentCount',
                'quizCount'
            )
        );
    }
}