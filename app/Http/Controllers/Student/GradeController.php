<?php

namespace App\Http\Controllers\Student;

use App\Models\ClassSubject;
use App\Models\QuarterlyGrade;

class GradeController extends BaseStudentController
{
    public function index()
    {
        $enrollment =
            $this->currentEnrollment();

        $subjects =
            ClassSubject::with([
                'subject',
                'teacher',
            ])
                ->where(
                    'section_id',
                    $enrollment->section_id
                )
                ->get();

        $grades =
            QuarterlyGrade::where(
                'enrollment_id',
                $enrollment->id
            )
                ->where(
                    'status',
                    'finalized'
                )
                ->get()
                ->groupBy(
                    'class_subject_id'
                );

        return view(
            'student.grades.index',
            compact(
                'subjects',
                'grades',
                'enrollment'
            )
        );
    }
}