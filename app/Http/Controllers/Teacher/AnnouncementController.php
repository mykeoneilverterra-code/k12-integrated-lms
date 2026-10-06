<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use App\Models\ClassSubject;

class AnnouncementController
    extends BaseTeacherController
{
    public function index(
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $announcements =
            $classSubject
                ->announcements()
                ->latest()
                ->paginate(15);

        return view(
            'teacher.announcements.index',
            compact(
                'classSubject',
                'announcements'
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
            'teacher.announcements.form',
            compact('classSubject')
        );
    }

    public function store(
        AnnouncementRequest $request,
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

        $data['class_subject_id'] =
            $classSubject->id;

        $data['teacher_id'] =
            $this
                ->currentTeacher()
                ->id;

        Announcement::create($data);

        return redirect()
            ->route(
                'teacher.announcements.index',
                $classSubject
            )
            ->with(
                'success',
                'Announcement created.'
            );
    }

    public function edit(
        ClassSubject $classSubject,
        Announcement $announcement
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        abort_unless(
            $announcement
                ->class_subject_id
            === $classSubject->id,
            404
        );

        return view(
            'teacher.announcements.form',
            compact(
                'classSubject',
                'announcement'
            )
        );
    }

    public function update(
        AnnouncementRequest $request,
        ClassSubject $classSubject,
        Announcement $announcement
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $this->ensureEditable(
            $classSubject
        );

        abort_unless(
            $announcement
                ->class_subject_id
            === $classSubject->id,
            404
        );

        $announcement->update(
            $request->validated()
        );

        return redirect()
            ->route(
                'teacher.announcements.index',
                $classSubject
            )
            ->with(
                'success',
                'Announcement updated.'
            );
    }

    public function destroy(
        ClassSubject $classSubject,
        Announcement $announcement
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $this->ensureEditable(
            $classSubject
        );

        abort_unless(
            $announcement
                ->class_subject_id
            === $classSubject->id,
            404
        );

        $announcement->delete();

        return back()->with(
            'success',
            'Announcement deleted.'
        );
    }
}