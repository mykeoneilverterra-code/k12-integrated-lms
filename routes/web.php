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
use App\Http\Controllers\Teacher\AnnouncementController;
use App\Http\Controllers\Teacher\AssignmentController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\ClassController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\Teacher\LessonController;
use App\Http\Controllers\Teacher\QuizController;
use App\Http\Controllers\Teacher\QuizQuestionController;
use App\Http\Controllers\Teacher\SubmissionController;
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
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [
                TeacherDashboardController::class,
                'index'
            ]
        )->name('dashboard');


        Route::get(
            '/classes',
            [
                ClassController::class,
                'index'
            ]
        )->name('classes.index');


        Route::get(
            '/classes/{classSubject}',
            [
                ClassController::class,
                'show'
            ]
        )->name('classes.show');


        Route::get(
            '/classes/{classSubject}/students',
            [
                ClassController::class,
                'students'
            ]
        )->name('classes.students');


        /*
        | Lessons
        */

        Route::get(
            '/classes/{classSubject}/lessons',
            [
                LessonController::class,
                'index'
            ]
        )->name('lessons.index');

        Route::get(
            '/classes/{classSubject}/lessons/create',
            [
                LessonController::class,
                'create'
            ]
        )->name('lessons.create');

        Route::post(
            '/classes/{classSubject}/lessons',
            [
                LessonController::class,
                'store'
            ]
        )->name('lessons.store');

        Route::get(
            '/classes/{classSubject}/lessons/{lesson}/edit',
            [
                LessonController::class,
                'edit'
            ]
        )->name('lessons.edit');

        Route::put(
            '/classes/{classSubject}/lessons/{lesson}',
            [
                LessonController::class,
                'update'
            ]
        )->name('lessons.update');

        Route::delete(
            '/classes/{classSubject}/lessons/{lesson}',
            [
                LessonController::class,
                'destroy'
            ]
        )->name('lessons.destroy');


        /*
        | Assignments
        */

        Route::get(
            '/classes/{classSubject}/assignments',
            [
                AssignmentController::class,
                'index'
            ]
        )->name('assignments.index');

        Route::get(
            '/classes/{classSubject}/assignments/create',
            [
                AssignmentController::class,
                'create'
            ]
        )->name('assignments.create');

        Route::post(
            '/classes/{classSubject}/assignments',
            [
                AssignmentController::class,
                'store'
            ]
        )->name('assignments.store');

        Route::get(
            '/classes/{classSubject}/assignments/{assignment}/edit',
            [
                AssignmentController::class,
                'edit'
            ]
        )->name('assignments.edit');

        Route::put(
            '/classes/{classSubject}/assignments/{assignment}',
            [
                AssignmentController::class,
                'update'
            ]
        )->name('assignments.update');

        Route::delete(
            '/classes/{classSubject}/assignments/{assignment}',
            [
                AssignmentController::class,
                'destroy'
            ]
        )->name('assignments.destroy');


        Route::get(
            '/classes/{classSubject}/assignments/{assignment}/submissions',
            [
                SubmissionController::class,
                'index'
            ]
        )->name('submissions.index');

        Route::put(
            '/classes/{classSubject}/assignments/{assignment}/submissions/{submission}',
            [
                SubmissionController::class,
                'update'
            ]
        )->name('submissions.update');


        /*
        | Quizzes
        */

        Route::get(
            '/classes/{classSubject}/quizzes',
            [
                QuizController::class,
                'index'
            ]
        )->name('quizzes.index');

        Route::get(
            '/classes/{classSubject}/quizzes/create',
            [
                QuizController::class,
                'create'
            ]
        )->name('quizzes.create');

        Route::post(
            '/classes/{classSubject}/quizzes',
            [
                QuizController::class,
                'store'
            ]
        )->name('quizzes.store');

        Route::get(
            '/classes/{classSubject}/quizzes/{quiz}',
            [
                QuizController::class,
                'show'
            ]
        )->name('quizzes.show');

        Route::get(
            '/classes/{classSubject}/quizzes/{quiz}/edit',
            [
                QuizController::class,
                'edit'
            ]
        )->name('quizzes.edit');

        Route::put(
            '/classes/{classSubject}/quizzes/{quiz}',
            [
                QuizController::class,
                'update'
            ]
        )->name('quizzes.update');

        Route::delete(
            '/classes/{classSubject}/quizzes/{quiz}',
            [
                QuizController::class,
                'destroy'
            ]
        )->name('quizzes.destroy');


        Route::post(
            '/classes/{classSubject}/quizzes/{quiz}/questions',
            [
                QuizQuestionController::class,
                'store'
            ]
        )->name('questions.store');

        Route::delete(
            '/classes/{classSubject}/quizzes/{quiz}/questions/{question}',
            [
                QuizQuestionController::class,
                'destroy'
            ]
        )->name('questions.destroy');


        /*
        | Attendance
        */

        Route::get(
            '/classes/{classSubject}/attendance',
            [
                AttendanceController::class,
                'index'
            ]
        )->name('attendance.index');

        Route::post(
            '/classes/{classSubject}/attendance',
            [
                AttendanceController::class,
                'store'
            ]
        )->name('attendance.store');


        /*
        | Grades
        */

        Route::get(
            '/classes/{classSubject}/grades',
            [
                GradeController::class,
                'index'
            ]
        )->name('grades.index');

        Route::post(
            '/classes/{classSubject}/grades',
            [
                GradeController::class,
                'store'
            ]
        )->name('grades.store');


        /*
        | Announcements
        */

        Route::get(
            '/classes/{classSubject}/announcements',
            [
                AnnouncementController::class,
                'index'
            ]
        )->name('announcements.index');

        Route::get(
            '/classes/{classSubject}/announcements/create',
            [
                AnnouncementController::class,
                'create'
            ]
        )->name('announcements.create');

        Route::post(
            '/classes/{classSubject}/announcements',
            [
                AnnouncementController::class,
                'store'
            ]
        )->name('announcements.store');

        Route::get(
            '/classes/{classSubject}/announcements/{announcement}/edit',
            [
                AnnouncementController::class,
                'edit'
            ]
        )->name('announcements.edit');

        Route::put(
            '/classes/{classSubject}/announcements/{announcement}',
            [
                AnnouncementController::class,
                'update'
            ]
        )->name('announcements.update');

        Route::delete(
            '/classes/{classSubject}/announcements/{announcement}',
            [
                AnnouncementController::class,
                'destroy'
            ]
        )->name('announcements.destroy');
    });