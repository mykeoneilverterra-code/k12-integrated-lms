<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolYearRequest;
use App\Models\SchoolYear;
use Illuminate\Support\Facades\DB;

class SchoolYearController extends Controller
{
    public function index()
    {
        $schoolYears = SchoolYear::latest(
            'starts_on'
        )->paginate(10);

        return view(
            'admin.school-years.index',
            compact('schoolYears')
        );
    }

    public function create()
    {
        return view(
            'admin.school-years.form'
        );
    }

    public function store(
        SchoolYearRequest $request
    ) {
        DB::transaction(function ()
        use ($request) {

            $data = $request->validated();

            if ($data['status'] === 'active') {
                SchoolYear::where(
                    'status',
                    'active'
                )->update([
                    'status' => 'closed'
                ]);
            }

            SchoolYear::create($data);
        });

        return redirect()
            ->route(
                'admin.school-years.index'
            )
            ->with(
                'success',
                'School year created.'
            );
    }

    public function edit(
        SchoolYear $schoolYear
    ) {
        return view(
            'admin.school-years.form',
            compact('schoolYear')
        );
    }

    public function update(
        SchoolYearRequest $request,
        SchoolYear $schoolYear
    ) {
        DB::transaction(function ()
        use ($request, $schoolYear) {

            $data = $request->validated();

            if ($data['status'] === 'active') {

                SchoolYear::where(
                    'id',
                    '!=',
                    $schoolYear->id
                )
                    ->where(
                        'status',
                        'active'
                    )
                    ->update([
                        'status' => 'closed'
                    ]);
            }

            $schoolYear->update($data);
        });

        return redirect()
            ->route(
                'admin.school-years.index'
            )
            ->with(
                'success',
                'School year updated.'
            );
    }

    public function destroy(
        SchoolYear $schoolYear
    ) {
        if (
            $schoolYear->sections()->exists() ||
            $schoolYear->enrollments()->exists()
        ) {
            return back()->with(
                'error',
                'This school year already contains academic records and cannot be deleted.'
            );
        }

        $schoolYear->delete();

        return back()->with(
            'success',
            'School year deleted.'
        );
    }
}