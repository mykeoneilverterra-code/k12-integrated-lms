<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects =
            Subject::withCount([
                'gradeLevels',
                'classSubjects',
            ])
                ->orderBy('name')
                ->paginate(15);

        return view(
            'admin.subjects.index',
            compact('subjects')
        );
    }

    public function create()
    {
        return view(
            'admin.subjects.form'
        );
    }

    public function store(
        SubjectRequest $request
    ) {
        Subject::create(
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.subjects.index'
            )
            ->with(
                'success',
                'Subject created.'
            );
    }

    public function edit(Subject $subject)
    {
        return view(
            'admin.subjects.form',
            compact('subject')
        );
    }

    public function update(
        SubjectRequest $request,
        Subject $subject
    ) {
        $subject->update(
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.subjects.index'
            )
            ->with(
                'success',
                'Subject updated.'
            );
    }

    public function destroy(Subject $subject)
    {
        if (
            $subject->classSubjects()
                ->exists()
        ) {
            return back()->with(
                'error',
                'Subject is already assigned to classes.'
            );
        }

        $subject->delete();

        return back()->with(
            'success',
            'Subject deleted.'
        );
    }
}