<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\SubmissionGradeRequest;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassSubject;

class SubmissionController
    extends BaseTeacherController
{
    public function index(
        ClassSubject $classSubject,
        Assignment $assignment
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        abort_unless(
            $assignment
                ->class_subject_id
            === $classSubject->id,
            404
        );

        $enrollments =
            $classSubject
                ->enrollments()
                ->with('student')
                ->where(
                    'status',
                    'enrolled'
                )
                ->get();

        $submissions =
            $assignment
                ->submissions()
                ->with(
                    'enrollment.student'
                )
                ->get()
                ->keyBy(
                    'enrollment_id'
                );

        return view(
            'teacher.assignments.submissions',
            compact(
                'classSubject',
                'assignment',
                'enrollments',
                'submissions'
            )
        );
    }

    public function update(
        SubmissionGradeRequest $request,
        ClassSubject $classSubject,
        Assignment $assignment,
        AssignmentSubmission $submission
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $this->ensureEditable(
            $classSubject
        );

        abort_unless(
            $assignment
                ->class_subject_id
            === $classSubject->id,
            404
        );

        abort_unless(
            $submission
                ->assignment_id
            === $assignment->id,
            404
        );

        $data =
            $request->validated();

        if (
            $data['score']
            >
            $assignment
                ->total_points
        ) {
            return back()
                ->withErrors([
                    'score' =>
                        'Score cannot exceed total points.'
                ]);
        }

        $submission->update([
            'score' =>
                $data['score'],

            'feedback' =>
                $data['feedback']
                ?? null,

            'status' =>
                'graded',

            'graded_at' =>
                now(),

            'graded_by_teacher_id'
                =>
                $this
                    ->currentTeacher()
                    ->id,
        ]);

        return back()->with(
            'success',
            'Submission graded.'
        );
    }
}