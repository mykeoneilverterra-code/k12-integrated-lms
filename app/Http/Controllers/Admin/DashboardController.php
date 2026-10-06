<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\GradeLevel;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $activeSchoolYear = SchoolYear::active()
            ->first();

        $studentCount = Student::where(
            'status',
            'active'
        )->count();

        $teacherCount = Teacher::where(
            'status',
            'active'
        )->count();

        $gradeLevelCount = GradeLevel::where(
            'education_stage',
            'elementary'
        )->count();

        $sectionCount = Section::when(
            $activeSchoolYear,
            fn ($query) =>
                $query->where(
                    'school_year_id',
                    $activeSchoolYear->id
                )
        )->count();

        $gradeLevels = GradeLevel::with([
            'sections' => function ($query)
            use ($activeSchoolYear) {

                if ($activeSchoolYear) {
                    $query->where(
                        'school_year_id',
                        $activeSchoolYear->id
                    );
                }

                $query->withCount(
                    'enrollments'
                );
            }
        ])
            ->where(
                'education_stage',
                'elementary'
            )
            ->orderBy('level')
            ->get();

        $chartLabels = $gradeLevels
            ->pluck('name')
            ->values();

        $chartData = $gradeLevels
            ->map(
                fn ($grade) =>
                    $grade->sections
                        ->sum(
                            'enrollments_count'
                        )
            )
            ->values();

        $recentEnrollments =
            Enrollment::with([
                'student',
                'section.gradeLevel',
            ])
                ->when(
                    $activeSchoolYear,
                    fn ($query) =>
                        $query->where(
                            'school_year_id',
                            $activeSchoolYear->id
                        )
                )
                ->latest()
                ->take(5)
                ->get();

        return view(
            'admin.dashboard',
            compact(
                'activeSchoolYear',
                'studentCount',
                'teacherCount',
                'gradeLevelCount',
                'sectionCount',
                'chartLabels',
                'chartData',
                'recentEnrollments'
            )
        );
    }
}