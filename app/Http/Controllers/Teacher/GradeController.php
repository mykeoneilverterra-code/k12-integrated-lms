<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\GradeRequest;
use App\Models\ClassSubject;
use App\Models\QuarterlyGrade;
use Illuminate\Http\Request;

class GradeController
    extends BaseTeacherController
{
    public function index(
        Request $request,
        ClassSubject $classSubject
    ) {
        $classSubject =
            $this->ownedClass(
                $classSubject
            );

        $quarter =
            (int) (
                $request->quarter
                ?? 1
            );

        if (
            $quarter < 1 ||
            $quarter > 4
        ) {
            $quarter = 1;
        }

        $enrollments =
            $classSubject
                ->enrollments()
                ->with('student')
                ->where(
                    'status',
                    'enrolled'
                )
                ->get();

        $grades =
            QuarterlyGrade::where(
                'class_subject_id',
                $classSubject->id
            )
                ->where(
                    'quarter',
                    $quarter
                )
                ->get()
                ->keyBy(
                    'enrollment_id'
                );

        return view(
            'teacher.grades.index',
            compact(
                'classSubject',
                'quarter',
                'enrollments',
                'grades'
            )
        );
    }

    public function store(
        GradeRequest $request,
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

        $validEnrollments =
            $classSubject
                ->enrollments()
                ->where(
                    'status',
                    'enrolled'
                )
                ->pluck('id');

        foreach (
            $data['grades']
            as $enrollmentId
                => $grade
        ) {
            if (
                $grade === null ||
                $grade === ''
            ) {
                continue;
            }

            if (
                ! $validEnrollments
                    ->contains(
                        (int)
                        $enrollmentId
                    )
            ) {
                continue;
            }

            $existing =
                QuarterlyGrade::where([
                    'class_subject_id'
                        =>
                        $classSubject->id,

                    'enrollment_id'
                        =>
                        $enrollmentId,

                    'quarter'
                        =>
                        $data['quarter'],
                ])->first();

            if (
                $existing?->status
                === 'finalized'
            ) {
                continue;
            }

            QuarterlyGrade::updateOrCreate(
                [
                    'class_subject_id'
                        =>
                        $classSubject->id,

                    'enrollment_id'
                        =>
                        $enrollmentId,

                    'quarter'
                        =>
                        $data['quarter'],
                ],
                [
                    'grade' =>
                        $grade,

                    'status' =>
                        $data['action']
                        === 'finalize'
                        ? 'finalized'
                        : 'draft',

                    'finalized_at' =>
                        $data['action']
                        === 'finalize'
                        ? now()
                        : null,

                    'graded_by_teacher_id'
                        =>
                        $this
                            ->currentTeacher()
                            ->id,
                ]
            );
        }

        return redirect()
            ->route(
                'teacher.grades.index',
                [
                    $classSubject,
                    'quarter'
                        =>
                        $data['quarter'],
                ]
            )
            ->with(
                'success',
                $data['action']
                === 'finalize'
                    ? 'Grades finalized.'
                    : 'Draft grades saved.'
            );
    }
}