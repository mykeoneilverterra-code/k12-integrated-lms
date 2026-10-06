<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentRequest;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $activeSchoolYear =
            SchoolYear::active()->first();

        $selectedSchoolYearId =
            $request->school_year_id
            ?? $activeSchoolYear?->id;

        $enrollments =
            Enrollment::with([
                'student',
                'schoolYear',
                'section.gradeLevel',
            ])
                ->when(
                    $selectedSchoolYearId,
                    fn ($query) =>
                        $query->where(
                            'school_year_id',
                            $selectedSchoolYearId
                        )
                )
                ->latest()
                ->paginate(20)
                ->withQueryString();

        $schoolYears =
            SchoolYear::orderByDesc(
                'starts_on'
            )->get();

        return view(
            'admin.enrollments.index',
            compact(
                'enrollments',
                'schoolYears',
                'selectedSchoolYearId'
            )
        );
    }

    public function create()
    {
        return view(
            'admin.enrollments.form',
            $this->formData()
        );
    }

    public function store(
        EnrollmentRequest $request
    ) {
        Enrollment::create(
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.enrollments.index'
            )
            ->with(
                'success',
                'Student enrolled successfully.'
            );
    }

    public function edit(
        Enrollment $enrollment
    ) {
        return view(
            'admin.enrollments.form',
            array_merge(
                $this->formData(),
                compact('enrollment')
            )
        );
    }

    public function update(
        EnrollmentRequest $request,
        Enrollment $enrollment
    ) {
        if (
            $enrollment->schoolYear
                ->status === 'closed'
        ) {
            return back()->with(
                'error',
                'Closed school-year records cannot be edited.'
            );
        }

        $enrollment->update(
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.enrollments.index'
            )
            ->with(
                'success',
                'Enrollment updated.'
            );
    }

    public function destroy(
        Enrollment $enrollment
    ) {
        if (
            $enrollment->schoolYear
                ->status === 'closed'
        ) {
            return back()->with(
                'error',
                'Closed school-year records cannot be deleted.'
            );
        }

        $enrollment->delete();

        return back()->with(
            'success',
            'Enrollment deleted.'
        );
    }

    private function formData(): array
    {
        return [
            'students' =>
                Student::where(
                    'status',
                    'active'
                )
                    ->orderBy(
                        'last_name'
                    )
                    ->get(),

            'schoolYears' =>
                SchoolYear::where(
                    'status',
                    '!=',
                    'closed'
                )
                    ->orderByDesc(
                        'starts_on'
                    )
                    ->get(),

            'sections' =>
                Section::with([
                    'schoolYear',
                    'gradeLevel',
                ])
                    ->orderBy(
                        'grade_level_id'
                    )
                    ->orderBy('name')
                    ->get(),
        ];
    }
}