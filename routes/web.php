<?php

use App\Http\Controllers\Admin\ClassAssignmentController;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\GradeLevelController;
use App\Http\Controllers\Admin\SchoolYearController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {

    Route::get(
        '/login',
        [AuthController::class, 'showLogin']
    )->name('login');

    Route::post(
        '/login',
        [AuthController::class, 'login']
    )->name('login.submit');
});

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)
    ->middleware('auth')
    ->name('logout');


Route::middleware([
    'auth',
    'role:admin'
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [
                AdminDashboardController::class,
                'index'
            ]
        )->name('dashboard');


        Route::resource(
            'school-years',
            SchoolYearController::class
        )->except([
            'show'
        ]);


        Route::resource(
            'grade-levels',
            GradeLevelController::class
        )->except([
            'show'
        ]);


        Route::resource(
            'sections',
            SectionController::class
        )->except([
            'show'
        ]);


        Route::resource(
            'subjects',
            SubjectController::class
        )->except([
            'show'
        ]);


        Route::get(
            '/curriculum',
            [
                CurriculumController::class,
                'index'
            ]
        )->name(
            'curriculum.index'
        );

        Route::get(
            '/curriculum/{gradeLevel}/edit',
            [
                CurriculumController::class,
                'edit'
            ]
        )->name(
            'curriculum.edit'
        );

        Route::put(
            '/curriculum/{gradeLevel}',
            [
                CurriculumController::class,
                'update'
            ]
        )->name(
            'curriculum.update'
        );


        Route::resource(
            'teachers',
            TeacherController::class
        )->except([
            'show'
        ]);


        Route::resource(
            'students',
            StudentController::class
        )->except([
            'show'
        ]);


        Route::resource(
            'enrollments',
            EnrollmentController::class
        )->except([
            'show'
        ]);


        Route::post(
            '/class-assignments/generate/{section}',
            [
                ClassAssignmentController::class,
                'generate'
            ]
        )->name(
            'class-assignments.generate'
        );


        Route::resource(
            'class-assignments',
            ClassAssignmentController::class
        )->except([
            'show'
        ]);
    });


/*
|--------------------------------------------------------------------------
| Temporary Teacher / Student routes
|--------------------------------------------------------------------------
| Full dashboards will be created in Phase 3 and 4.
*/

Route::middleware([
    'auth',
    'role:teacher'
])
    ->get(
        '/teacher/dashboard',
        fn () => '<h1>Teacher Dashboard - Phase 3</h1>'
    )
    ->name('teacher.dashboard');


Route::middleware([
    'auth',
    'role:student'
])
    ->get(
        '/student/dashboard',
        fn () => '<h1>Student Dashboard - Phase 4</h1>'
    )
    ->name('student.dashboard');