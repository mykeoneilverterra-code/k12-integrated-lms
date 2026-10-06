<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $activeSchoolYear =
            SchoolYear::active()->first();

        $students = Student::with([
            'enrollments' => function ($query)
            use ($activeSchoolYear) {

                if ($activeSchoolYear) {
                    $query->where(
                        'school_year_id',
                        $activeSchoolYear->id
                    );
                }

                $query->with([
                    'section.gradeLevel'
                ]);
            },
        ])
            ->when(
                $request->search,
                function ($query, $search) {

                    $query->where(
                        function ($q)
                        use ($search) {

                            $q->where(
                                'student_number',
                                'like',
                                "%{$search}%"
                            )
                                ->orWhere(
                                    'first_name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'last_name',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )
            ->orderBy('last_name')
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.students.index',
            compact('students')
        );
    }

    public function create()
    {
        return view(
            'admin.students.form'
        );
    }

    public function store(
        StudentRequest $request
    ) {
        $studentNumber =
            $this->generateStudentNumber();

        DB::transaction(function ()
        use (
            $request,
            $studentNumber
        ) {
            $data = $request->validated();

            $loginEmail =
                $data['email']
                ?: strtolower(
                    $studentNumber
                ) . '@student.local';

            $user = User::create([
                'name' => trim(
                    $data['first_name'] . ' ' .
                    $data['last_name']
                ),
                'email' => $loginEmail,
                'password' =>
                    $data['password'],
                'role' => 'student',
            ]);

            unset(
                $data['password'],
                $data['password_confirmation']
            );

            $data['user_id'] =
                $user->id;

            $data['student_number'] =
                $studentNumber;

            Student::create($data);
        });

        return redirect()
            ->route(
                'admin.students.index'
            )
            ->with(
                'success',
                "Student created. Student Number: {$studentNumber}"
            );
    }

    public function edit(Student $student)
    {
        return view(
            'admin.students.form',
            compact('student')
        );
    }

    public function update(
        StudentRequest $request,
        Student $student
    ) {
        DB::transaction(function ()
        use ($request, $student) {

            $data = $request->validated();

            $password =
                $data['password'] ?? null;

            unset(
                $data['password'],
                $data['password_confirmation']
            );

            $student->update($data);

            if ($student->user) {

                $loginEmail =
                    $student->email
                    ?: strtolower(
                        $student->student_number
                    ) . '@student.local';

                $userData = [
                    'name' => $student->full_name,
                    'email' => $loginEmail,
                ];

                if ($password) {
                    $userData['password'] =
                        $password;
                }

                $student->user->update(
                    $userData
                );
            }
        });

        return redirect()
            ->route(
                'admin.students.index'
            )
            ->with(
                'success',
                'Student updated.'
            );
    }

    public function destroy(Student $student)
    {
        DB::transaction(function ()
        use ($student) {

            $user = $student->user;

            $student->update([
                'status' => 'inactive',
            ]);

            $user?->delete();
        });

        return back()->with(
            'success',
            'Student account deactivated.'
        );
    }

    private function generateStudentNumber(): string
    {
        $schoolYear =
            SchoolYear::active()->first();

        $prefix = $schoolYear
            ? substr(
                $schoolYear->name,
                0,
                4
            )
            : now()->format('Y');

        $latest = Student::withTrashed()
            ->where(
                'student_number',
                'like',
                "{$prefix}-%"
            )
            ->orderByDesc(
                'student_number'
            )
            ->value(
                'student_number'
            );

        $next = 1;

        if ($latest) {
            $next =
                (int) substr(
                    $latest,
                    -5
                ) + 1;
        }

        return $prefix . '-' .
            str_pad(
                $next,
                5,
                '0',
                STR_PAD_LEFT
            );
    }
}