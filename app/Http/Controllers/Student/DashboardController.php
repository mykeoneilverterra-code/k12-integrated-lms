<?php

namespace App\Http\Controllers\Student;

use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassSubject;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuarterlyGrade;

class DashboardController extends BaseStudentController
{
    public function index()
    {
        $student = $this->currentStudent();
        $enrollment = $this->currentEnrollment();

        $subjects = ClassSubject::with([
            'subject',
            'teacher',
            'section.gradeLevel',
        ])
            ->where('section_id', $enrollment->section_id)
            ->get();

        $classSubjectIds = $subjects->pluck('id');

        $upcomingAssignments = Assignment::whereIn(
            'class_subject_id',
            $classSubjectIds
        )
            ->where('is_published', true)
            ->whereNotNull('due_at')
            ->where('due_at', '>=', now())
            ->count();

        $upcomingQuizzes = Quiz::whereIn(
            'class_subject_id',
            $classSubjectIds
        )
            ->where('is_published', true)
            ->where(function ($query) {
                $query
                    ->whereNull('closes_at')
                    ->orWhere('closes_at', '>=', now());
            })
            ->count();

        $submittedAssignments =
            AssignmentSubmission::where(
                'enrollment_id',
                $enrollment->id
            )->count();

        $completedQuizzes =
            QuizAttempt::where(
                'enrollment_id',
                $enrollment->id
            )
                ->where('status', 'submitted')
                ->count();

        $completedActivities =
            $submittedAssignments +
            $completedQuizzes;

        $generalAverage =
            QuarterlyGrade::where(
                'enrollment_id',
                $enrollment->id
            )
                ->where('status', 'finalized')
                ->avg('grade');

        $announcements =
            Announcement::with([
                'classSubject.subject'
            ])
                ->whereIn(
                    'class_subject_id',
                    $classSubjectIds
                )
                ->whereNotNull('published_at')
                ->where(
                    'published_at',
                    '<=',
                    now()
                )
                ->latest('published_at')
                ->take(5)
                ->get();

        return view(
            'student.dashboard',
            compact(
                'student',
                'enrollment',
                'subjects',
                'upcomingAssignments',
                'upcomingQuizzes',
                'completedActivities',
                'generalAverage',
                'announcements'
            )
        );
    }
}