<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $teachers = Teacher::with('user')
            ->when(
                $request->search,
                function ($query, $search) {

                    $query->where(
                        function ($q)
                        use ($search) {

                            $q->where(
                                'employee_number',
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
            'admin.teachers.index',
            compact('teachers')
        );
    }

    public function create()
    {
        return view(
            'admin.teachers.form'
        );
    }

    public function store(
        TeacherRequest $request
    ) {
        DB::transaction(function ()
        use ($request) {

            $data = $request->validated();

            $fullName = trim(
                $data['first_name'] . ' ' .
                $data['last_name']
            );

            $user = User::create([
                'name' => $fullName,
                'email' => $data['email'],
                'password' =>
                    $data['password'],
                'role' => 'teacher',
            ]);

            unset(
                $data['password'],
                $data['password_confirmation']
            );

            $data['user_id'] = $user->id;

            Teacher::create($data);
        });

        return redirect()
            ->route(
                'admin.teachers.index'
            )
            ->with(
                'success',
                'Teacher created.'
            );
    }

    public function edit(Teacher $teacher)
    {
        return view(
            'admin.teachers.form',
            compact('teacher')
        );
    }

    public function update(
        TeacherRequest $request,
        Teacher $teacher
    ) {
        DB::transaction(function ()
        use ($request, $teacher) {

            $data = $request->validated();

            $password =
                $data['password'] ?? null;

            unset(
                $data['password'],
                $data['password_confirmation']
            );

            $teacher->update($data);

            if ($teacher->user) {

                $userData = [
                    'name' => $teacher->full_name,
                    'email' => $teacher->email,
                ];

                if ($password) {
                    $userData['password'] =
                        $password;
                }

                $teacher->user->update(
                    $userData
                );
            }
        });

        return redirect()
            ->route(
                'admin.teachers.index'
            )
            ->with(
                'success',
                'Teacher updated.'
            );
    }

    public function destroy(Teacher $teacher)
    {
        DB::transaction(function ()
        use ($teacher) {

            $user = $teacher->user;

            $teacher->update([
                'status' => 'inactive',
            ]);

            $user?->delete();
        });

        return back()->with(
            'success',
            'Teacher account deactivated.'
        );
    }
}