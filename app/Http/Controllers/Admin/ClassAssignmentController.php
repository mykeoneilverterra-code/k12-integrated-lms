<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassAssignmentRequest;
use App\Models\ClassSubject;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $activeSchoolYear =
            SchoolYear::active()->first();

        $sections =
            Section::with([
                'gradeLevel',
                'schoolYear',
            ])
                ->when(
                    $activeSchoolYear,
                    fn ($query) =>
                        $query->where(
                            'school_year_id',
                            $activeSchoolYear->id
                        )
                )
                ->orderBy(
                    'grade_level_id'
                )
                ->orderBy('name')
                ->get();

        $selectedSectionId =
            $request->section_id
            ?? $sections->first()?->id;

        $assignments =
            ClassSubject::with([
                'section.gradeLevel',
                'section.schoolYear',
                'subject',
                'teacher',
            ])
                ->when(
                    $selectedSectionId,
                    fn ($query) =>
                        $query->where(
                            'section_id',
                            $selectedSectionId
                        )
                )
                ->paginate(20)
                ->withQueryString();

        return view(
            'admin.class-assignments.index',
            compact(
                'assignments',
                'sections',
                'selectedSectionId'
            )
        );
    }

    public function create()
    {
        return view(
            'admin.class-assignments.form',
            $this->formData()
        );
    }

    public function store(
        ClassAssignmentRequest $request
    ) {
        ClassSubject::create(
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.class-assignments.index'
            )
            ->with(
                'success',
                'Class assignment created.'
            );
    }

    public function edit(
        ClassSubject $class_assignment
    ) {
        $classAssignment =
            $class_assignment;

        return view(
            'admin.class-assignments.form',
            array_merge(
                $this->formData(),
                compact(
                    'classAssignment'
                )
            )
        );
    }

    public function update(
        ClassAssignmentRequest $request,
        ClassSubject $class_assignment
    ) {
        $class_assignment->update(
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.class-assignments.index'
            )
            ->with(
                'success',
                'Class assignment updated.'
            );
    }

    public function destroy(
        ClassSubject $class_assignment
    ) {
        $class_assignment->delete();

        return back()->with(
            'success',
            'Class assignment deleted.'
        );
    }

    public function generate(
        Section $section
    ) {
        $section->load(
            'gradeLevel.subjects'
        );

        $created = 0;

        foreach (
            $section->gradeLevel->subjects
            as $subject
        ) {
            $assignment =
                ClassSubject::firstOrCreate(
                    [
                        'section_id' =>
                            $section->id,

                        'subject_id' =>
                            $subject->id,
                    ],
                    [
                        'teacher_id' =>
                            null,
                    ]
                );

            if ($assignment->wasRecentlyCreated) {
                $created++;
            }
        }

        return back()->with(
            'success',
            "{$created} class subject(s) generated from the curriculum blueprint."
        );
    }

    private function formData(): array
    {
        $activeSchoolYear =
            SchoolYear::active()->first();

        return [
            'sections' =>
                Section::with([
                    'gradeLevel.subjects',
                    'schoolYear',
                ])
                    ->when(
                        $activeSchoolYear,
                        fn ($query) =>
                            $query->where(
                                'school_year_id',
                                $activeSchoolYear->id
                            )
                    )
                    ->orderBy(
                        'grade_level_id'
                    )
                    ->get(),

            'subjects' =>
                Subject::with(
                    'gradeLevels'
                )
                    ->where(
                        'is_active',
                        true
                    )
                    ->orderBy('name')
                    ->get(),

            'teachers' =>
                Teacher::where(
                    'status',
                    'active'
                )
                    ->orderBy(
                        'last_name'
                    )
                    ->get(),
        ];
    }
}