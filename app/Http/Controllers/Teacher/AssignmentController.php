<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Models\ClassSubject;
use Illuminate\Support\Facades\Storage;

class AssignmentController
    extends BaseTeacherController
{
    public function index(
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $assignments =
            $classSubject
                ->assignments()
                ->withCount(
                    'submissions'
                )
                ->latest()
                ->paginate(15);

        return view(
            'teacher.assignments.index',
            compact(
                'classSubject',
                'assignments'
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
            'teacher.assignments.form',
            compact('classSubject')
        );
    }

    public function store(
        AssignmentRequest $request,
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

        unset(
            $data['attachment']
        );

        $data['class_subject_id'] =
            $classSubject->id;

        $data['teacher_id'] =
            $this
                ->currentTeacher()
                ->id;

        if (
            $request->hasFile(
                'attachment'
            )
        ) {
            $data[
                'attachment_path'
            ] =
                $request
                    ->file(
                        'attachment'
                    )
                    ->store(
                        'assignments',
                        'public'
                    );
        }

        $data['published_at'] =
            $data['is_published']
            ? now()
            : null;

        Assignment::create($data);

        return redirect()
            ->route(
                'teacher.assignments.index',
                $classSubject
            )
            ->with(
                'success',
                'Assignment created.'
            );
    }

    public function edit(
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

        return view(
            'teacher.assignments.form',
            compact(
                'classSubject',
                'assignment'
            )
        );
    }

    public function update(
        AssignmentRequest $request,
        ClassSubject $classSubject,
        Assignment $assignment
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

        $data =
            $request->validated();

        unset(
            $data['attachment']
        );

        if (
            $request->hasFile(
                'attachment'
            )
        ) {
            if (
                $assignment
                    ->attachment_path
            ) {
                Storage::disk('public')
                    ->delete(
                        $assignment
                        ->attachment_path
                    );
            }

            $data[
                'attachment_path'
            ] =
                $request
                    ->file(
                        'attachment'
                    )
                    ->store(
                        'assignments',
                        'public'
                    );
        }

        $data['published_at'] =
            $data['is_published']
            ? (
                $assignment
                    ->published_at
                ?? now()
            )
            : null;

        $assignment->update(
            $data
        );

        return redirect()
            ->route(
                'teacher.assignments.index',
                $classSubject
            )
            ->with(
                'success',
                'Assignment updated.'
            );
    }

    public function destroy(
        ClassSubject $classSubject,
        Assignment $assignment
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

        if (
            $assignment
                ->submissions()
                ->exists()
        ) {
            return back()->with(
                'error',
                'Assignment already has submissions and cannot be deleted.'
            );
        }

        if (
            $assignment
                ->attachment_path
        ) {
            Storage::disk('public')
                ->delete(
                    $assignment
                    ->attachment_path
                );
        }

        $assignment->delete();

        return back()->with(
            'success',
            'Assignment deleted.'
        );
    }
}