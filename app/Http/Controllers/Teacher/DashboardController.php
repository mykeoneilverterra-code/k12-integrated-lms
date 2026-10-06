<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassSubject;
use App\Models\Enrollment;
use App\Models\Quiz;

class DashboardController
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

        $sectionIds =
            $classes
                ->pluck('section_id')
                ->unique();

        $totalStudents =
            Enrollment::whereIn(
                'section_id',
                $sectionIds
            )
                ->where(
                    'status',
                    'enrolled'
                )
                ->distinct()
                ->count('student_id');

        $pendingSubmissions =
            AssignmentSubmission::whereNull(
                'score'
            )
                ->whereHas(
                    'assignment.classSubject',
                    fn ($query) =>
                        $query->where(
                            'teacher_id',
                            $teacher->id
                        )
                )
                ->count();

        $upcomingAssignments =
            Assignment::whereHas(
                'classSubject',
                fn ($query) =>
                    $query->where(
                        'teacher_id',
                        $teacher->id
                    )
            )
                ->where(
                    'is_published',
                    true
                )
                ->whereNotNull('due_at')
                ->where(
                    'due_at',
                    '>=',
                    now()
                )
                ->count();

        $upcomingQuizzes =
            Quiz::whereHas(
                'classSubject',
                fn ($query) =>
                    $query->where(
                        'teacher_id',
                        $teacher->id
                    )
            )
                ->where(
                    'is_published',
                    true
                )
                ->whereNotNull(
                    'closes_at'
                )
                ->where(
                    'closes_at',
                    '>=',
                    now()
                )
                ->count();

        $upcomingActivities =
            $upcomingAssignments +
            $upcomingQuizzes;

        return view(
            'teacher.dashboard',
            compact(
                'teacher',
                'classes',
                'totalStudents',
                'pendingSubmissions',
                'upcomingActivities'
            )
        );
    }
}