<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\AttendanceRequest;
use App\Models\AttendanceRecord;
use App\Models\ClassSubject;
use Illuminate\Http\Request;

class AttendanceController
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

        $date =
            $request->date
            ?? now()->format('Y-m-d');

        $enrollments =
            $classSubject
                ->enrollments()
                ->with('student')
                ->where(
                    'status',
                    'enrolled'
                )
                ->get();

        $records =
            AttendanceRecord::where(
                'class_subject_id',
                $classSubject->id
            )
                ->whereDate(
                    'attendance_date',
                    $date
                )
                ->get()
                ->keyBy(
                    'enrollment_id'
                );

        return view(
            'teacher.attendance.index',
            compact(
                'classSubject',
                'date',
                'enrollments',
                'records'
            )
        );
    }

    public function store(
        AttendanceRequest $request,
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
            $data['attendance']
            as $enrollmentId
                => $status
        ) {
            if (
                ! $validEnrollments
                    ->contains(
                        (int)
                        $enrollmentId
                    )
            ) {
                continue;
            }

            AttendanceRecord::updateOrCreate(
                [
                    'class_subject_id'
                        =>
                        $classSubject->id,

                    'enrollment_id'
                        =>
                        $enrollmentId,

                    'attendance_date'
                        =>
                        $data[
                            'attendance_date'
                        ],
                ],
                [
                    'status' =>
                        $status,

                    'marked_by_teacher_id'
                        =>
                        $this
                            ->currentTeacher()
                            ->id,
                ]
            );
        }

        return back()->with(
            'success',
            'Attendance saved.'
        );
    }
}