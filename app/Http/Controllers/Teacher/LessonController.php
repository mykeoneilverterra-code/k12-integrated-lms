<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\LessonRequest;
use App\Models\ClassSubject;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;

class LessonController
    extends BaseTeacherController
{
    public function index(
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $lessons =
            $classSubject
                ->lessons()
                ->latest()
                ->paginate(15);

        return view(
            'teacher.lessons.index',
            compact(
                'classSubject',
                'lessons'
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
            'teacher.lessons.form',
            compact('classSubject')
        );
    }

    public function store(
        LessonRequest $request,
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

        unset($data['file']);

        $data['class_subject_id'] =
            $classSubject->id;

        $data['teacher_id'] =
            $this
                ->currentTeacher()
                ->id;

        if (
            $request->hasFile(
                'file'
            )
        ) {
            $data['file_path'] =
                $request
                    ->file('file')
                    ->store(
                        'lessons',
                        'public'
                    );
        }

        $data['published_at'] =
            $data['is_published']
            ? now()
            : null;

        Lesson::create($data);

        return redirect()
            ->route(
                'teacher.lessons.index',
                $classSubject
            )
            ->with(
                'success',
                'Lesson created.'
            );
    }

    public function edit(
        ClassSubject $classSubject,
        Lesson $lesson
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        abort_unless(
            $lesson->class_subject_id
            === $classSubject->id,
            404
        );

        return view(
            'teacher.lessons.form',
            compact(
                'classSubject',
                'lesson'
            )
        );
    }

    public function update(
        LessonRequest $request,
        ClassSubject $classSubject,
        Lesson $lesson
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $this->ensureEditable(
            $classSubject
        );

        abort_unless(
            $lesson->class_subject_id
            === $classSubject->id,
            404
        );

        $data =
            $request->validated();

        unset($data['file']);

        if (
            $request->hasFile(
                'file'
            )
        ) {
            if ($lesson->file_path) {
                Storage::disk('public')
                    ->delete(
                        $lesson->file_path
                    );
            }

            $data['file_path'] =
                $request
                    ->file('file')
                    ->store(
                        'lessons',
                        'public'
                    );
        }

        $data['published_at'] =
            $data['is_published']
            ? (
                $lesson->published_at
                ?? now()
            )
            : null;

        $lesson->update($data);

        return redirect()
            ->route(
                'teacher.lessons.index',
                $classSubject
            )
            ->with(
                'success',
                'Lesson updated.'
            );
    }

    public function destroy(
        ClassSubject $classSubject,
        Lesson $lesson
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $this->ensureEditable(
            $classSubject
        );

        abort_unless(
            $lesson->class_subject_id
            === $classSubject->id,
            404
        );

        if ($lesson->file_path) {
            Storage::disk('public')
                ->delete(
                    $lesson->file_path
                );
        }

        $lesson->delete();

        return back()->with(
            'success',
            'Lesson deleted.'
        );
    }
}