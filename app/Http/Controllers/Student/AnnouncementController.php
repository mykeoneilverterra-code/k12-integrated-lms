<?php

namespace App\Http\Controllers\Student;

use App\Models\Announcement;
use App\Models\ClassSubject;

class AnnouncementController
    extends BaseStudentController
{
    public function index()
    {
        $enrollment =
            $this->currentEnrollment();

        $classSubjectIds =
            ClassSubject::where(
                'section_id',
                $enrollment->section_id
            )
                ->pluck('id');

        $announcements =
            Announcement::with([
                'classSubject.subject',
                'teacher',
            ])
                ->whereIn(
                    'class_subject_id',
                    $classSubjectIds
                )
                ->whereNotNull(
                    'published_at'
                )
                ->where(
                    'published_at',
                    '<=',
                    now()
                )
                ->latest(
                    'published_at'
                )
                ->paginate(15);

        return view(
            'student.announcements.index',
            compact(
                'announcements'
            )
        );
    }
}