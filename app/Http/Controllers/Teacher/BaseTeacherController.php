<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\Teacher;

class BaseTeacherController
    extends Controller
{
    protected function currentTeacher(): Teacher
    {
        $teacher =
            auth()->user()?->teacher;

        abort_unless(
            $teacher &&
            $teacher->status === 'active',
            403
        );

        return $teacher;
    }

    protected function ownedClass(
        ClassSubject $classSubject
    ): ClassSubject {
        $teacher =
            $this->currentTeacher();

        abort_unless(
            (int) $classSubject->teacher_id
            ===
            (int) $teacher->id,
            403
        );

        return $classSubject;
    }

    protected function ensureEditable(
        ClassSubject $classSubject
    ): void {
        $classSubject->loadMissing(
            'section.schoolYear'
        );

        abort_if(
            $classSubject
                ->section
                ->schoolYear
                ->status
            === 'closed',
            403,
            'This school year is already closed.'
        );
    }
}