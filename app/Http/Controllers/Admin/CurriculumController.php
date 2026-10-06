<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurriculumRequest;
use App\Models\GradeLevel;
use App\Models\Subject;

class CurriculumController extends Controller
{
    public function index()
    {
        $gradeLevels =
            GradeLevel::with([
                'subjects' => fn ($query) =>
                    $query->orderBy('name')
            ])
                ->where(
                    'education_stage',
                    'elementary'
                )
                ->orderBy('level')
                ->get();

        return view(
            'admin.curriculum.index',
            compact('gradeLevels')
        );
    }

    public function edit(
        GradeLevel $gradeLevel
    ) {
        $gradeLevel->load('subjects');

        $subjects =
            Subject::where(
                'is_active',
                true
            )
                ->orderBy('name')
                ->get();

        return view(
            'admin.curriculum.edit',
            compact(
                'gradeLevel',
                'subjects'
            )
        );
    }

    public function update(
        CurriculumRequest $request,
        GradeLevel $gradeLevel
    ) {
        $data = $request->validated();

        $gradeLevel
            ->subjects()
            ->sync(
                $data['subjects'] ?? []
            );

        return redirect()
            ->route(
                'admin.curriculum.index'
            )
            ->with(
                'success',
                'Curriculum blueprint updated.'
            );
    }
}