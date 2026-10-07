<?php

namespace App\Http\Controllers\Student;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController
    extends BaseStudentController
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

        $assignments =
            $classSubject
                ->assignments()
                ->where(
                    'is_published',
                    true
                )
                ->latest()
                ->paginate(15);

        $submissions =
            AssignmentSubmission::where(
                'enrollment_id',
                $enrollment->id
            )
                ->whereIn(
                    'assignment_id',
                    $assignments
                        ->getCollection()
                        ->pluck('id')
                )
                ->get()
                ->keyBy('assignment_id');

        return view(
            'student.assignments.index',
            compact(
                'classSubject',
                'assignments',
                'submissions'
            )
        );
    }

    public function show(
        ClassSubject $classSubject,
        Assignment $assignment
    ) {
        $classSubject =
            $this->accessibleSubject(
                $classSubject
            );

        abort_unless(
            $assignment->class_subject_id
            === $classSubject->id &&
            $assignment->is_published,
            404
        );

        $enrollment =
            $this->currentEnrollment();

        $submission =
            AssignmentSubmission::where(
                'assignment_id',
                $assignment->id
            )
                ->where(
                    'enrollment_id',
                    $enrollment->id
                )
                ->first();

        return view(
            'student.assignments.show',
            compact(
                'classSubject',
                'assignment',
                'submission'
            )
        );
    }

    public function submit(
        Request $request,
        ClassSubject $classSubject,
        Assignment $assignment
    ) {
        $classSubject =
            $this->accessibleSubject(
                $classSubject
            );

        abort_unless(
            $assignment->class_subject_id
            === $classSubject->id &&
            $assignment->is_published,
            404
        );

        $request->validate([
            'file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png',
                'max:10240',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        if (
            ! $request->hasFile('file') &&
            ! $request->filled('notes')
        ) {
            return back()->withErrors([
                'file' =>
                    'Upload a file or enter a response.'
            ]);
        }

        $enrollment =
            $this->currentEnrollment();

        $submission =
            AssignmentSubmission::where(
                'assignment_id',
                $assignment->id
            )
                ->where(
                    'enrollment_id',
                    $enrollment->id
                )
                ->first();

        if (
            $submission &&
            $submission->status === 'graded'
        ) {
            return back()->with(
                'error',
                'This submission has already been graded.'
            );
        }

        $filePath =
            $submission?->file_path;

        if ($request->hasFile('file')) {

            if ($filePath) {
                Storage::disk('public')
                    ->delete($filePath);
            }

            $filePath =
                $request
                    ->file('file')
                    ->store(
                        'submissions',
                        'public'
                    );
        }

        $status =
            $assignment->due_at &&
            now()->greaterThan(
                $assignment->due_at
            )
                ? 'late'
                : 'submitted';

        AssignmentSubmission::updateOrCreate(
            [
                'assignment_id'
                    => $assignment->id,

                'enrollment_id'
                    => $enrollment->id,
            ],
            [
                'file_path'
                    => $filePath,

                'notes'
                    => $request->notes,

                'submitted_at'
                    => now(),

                'status'
                    => $status,

                'score'
                    => null,

                'feedback'
                    => null,

                'graded_at'
                    => null,

                'graded_by_teacher_id'
                    => null,
            ]
        );

        return back()->with(
            'success',
            'Assignment submitted successfully.'
        );
    }
}