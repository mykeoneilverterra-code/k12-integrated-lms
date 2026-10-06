<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeLevelRequest;
use App\Models\GradeLevel;

class GradeLevelController extends Controller
{
    public function index()
    {
        $gradeLevels =
            GradeLevel::withCount([
                'sections',
                'subjects',
            ])
                ->where(
                    'education_stage',
                    'elementary'
                )
                ->orderBy('level')
                ->paginate(10);

        return view(
            'admin.grade-levels.index',
            compact('gradeLevels')
        );
    }

    public function create()
    {
        return view(
            'admin.grade-levels.form'
        );
    }

    public function store(
        GradeLevelRequest $request
    ) {
        GradeLevel::create(
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.grade-levels.index'
            )
            ->with(
                'success',
                'Grade level created.'
            );
    }

    public function edit(
        GradeLevel $gradeLevel
    ) {
        return view(
            'admin.grade-levels.form',
            compact('gradeLevel')
        );
    }

    public function update(
        GradeLevelRequest $request,
        GradeLevel $gradeLevel
    ) {
        $gradeLevel->update(
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.grade-levels.index'
            )
            ->with(
                'success',
                'Grade level updated.'
            );
    }

    public function destroy(
        GradeLevel $gradeLevel
    ) {
        if (
            $gradeLevel->sections()->exists() ||
            $gradeLevel->subjects()->exists()
        ) {
            return back()->with(
                'error',
                'Grade level is already being used.'
            );
        }

        $gradeLevel->delete();

        return back()->with(
            'success',
            'Grade level deleted.'
        );
    }
}