<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\Enrollment;
use App\Models\Student;

class BaseStudentController extends Controller
{
    protected function currentStudent(): Student
    {
        $student = auth()->user()?->student;

        abort_unless($student, 403);

        return $student;
    }

    protected function currentEnrollment(): Enrollment
    {
        $student = $this->currentStudent();

        $enrollment = Enrollment::with([
            'schoolYear',
            'section.gradeLevel',
        ])
            ->where('student_id', $student->id)
            ->where('status', 'enrolled')
            ->whereHas('schoolYear', function ($query) {
                $query->where('status', 'active');
            })
            ->latest('id')
            ->first();

        abort_unless(
            $enrollment,
            403,
            'No active enrollment found.'
        );

        return $enrollment;
    }

    protected function accessibleSubject(
        ClassSubject $classSubject
    ): ClassSubject {
        $enrollment = $this->currentEnrollment();

        abort_unless(
            (int) $classSubject->section_id ===
            (int) $enrollment->section_id,
            403
        );

        return $classSubject;
    }
}