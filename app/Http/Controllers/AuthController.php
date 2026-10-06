<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $login = trim($data['login']);

        $user = null;

        // Login using email.
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $login)->first();
        }

        // Student Number login.
        if (! $user) {
            $student = Student::with('user')
                ->where('student_number', $login)
                ->first();

            $user = $student?->user;
        }

        // Employee Number login.
        if (! $user) {
            $teacher = Teacher::with('user')
                ->where('employee_number', $login)
                ->first();

            $user = $teacher?->user;
        }

        if (
            ! $user ||
            ! Hash::check($data['password'], $user->password)
        ) {
            return back()
                ->withErrors([
                    'login' => 'Invalid login credentials.',
                ])
                ->onlyInput('login');
        }

        Auth::login(
            $user,
            $request->boolean('remember')
        );

        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    private function redirectByRole(User $user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),

            'teacher' => redirect()->route('teacher.dashboard'),

            'student' => redirect()->route('student.dashboard'),

            default => redirect()->route('login'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}