<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\GradeLevel;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $activeSchoolYear =
            SchoolYear::active()->first();

        $selectedSchoolYearId =
            $request->school_year_id
            ?? $activeSchoolYear?->id;

        $sections = Section::with([
            'schoolYear',
            'gradeLevel',
            'adviser',
        ])
            ->withCount('enrollments')
            ->when(
                $selectedSchoolYearId,
                fn ($query) =>
                    $query->where(
                        'school_year_id',
                        $selectedSchoolYearId
                    )
            )
            ->orderBy('grade_level_id')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $schoolYears =
            SchoolYear::orderByDesc(
                'starts_on'
            )->get();

        return view(
            'admin.sections.index',
            compact(
                'sections',
                'schoolYears',
                'selectedSchoolYearId'
            )
        );
    }

    public function create()
    {
        return view(
            'admin.sections.form',
            $this->formData()
        );
    }

    public function store(
        SectionRequest $request
    ) {
        Section::create(
            $request->validated()
        );

        return redirect()
            ->route('admin.sections.index')
            ->with(
                'success',
                'Section created.'
            );
    }

    public function edit(Section $section)
    {
        return view(
            'admin.sections.form',
            array_merge(
                $this->formData(),
                compact('section')
            )
        );
    }

    public function update(
        SectionRequest $request,
        Section $section
    ) {
        $section->update(
            $request->validated()
        );

        return redirect()
            ->route('admin.sections.index')
            ->with(
                'success',
                'Section updated.'
            );
    }

    public function destroy(Section $section)
    {
        if (
            $section->enrollments()->exists() ||
            $section->classSubjects()->exists()
        ) {
            return back()->with(
                'error',
                'This section already contains academic records.'
            );
        }

        $section->delete();

        return back()->with(
            'success',
            'Section deleted.'
        );
    }

    private function formData(): array
    {
        return [
            'schoolYears' =>
                SchoolYear::orderByDesc(
                    'starts_on'
                )->get(),

            'gradeLevels' =>
                GradeLevel::where(
                    'education_stage',
                    'elementary'
                )
                    ->orderBy('level')
                    ->get(),

            'teachers' =>
                Teacher::where(
                    'status',
                    'active'
                )
                    ->orderBy('last_name')
                    ->get(),
        ];
    }
}