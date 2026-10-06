@extends('layouts.admin')

@php
    $editing = isset($section);
@endphp

@section(
    'title',
    $editing
        ? 'Edit Section'
        : 'Add Section'
)

@section(
    'page-title',
    $editing
        ? 'Edit Section'
        : 'Add Section'
)

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card form-card">

            <div class="card-body p-4">

                <form
                    method="POST"
                    action="{{
                        $editing
                        ? route(
                            'admin.sections.update',
                            $section
                        )
                        : route(
                            'admin.sections.store'
                        )
                    }}"
                >

                    @csrf

                    @if ($editing)
                        @method('PUT')
                    @endif


                    <div class="mb-3">

                        <label class="form-label">
                            School Year
                        </label>

                        <select
                            name="school_year_id"
                            class="form-select"
                        >

                            @foreach (
                                $schoolYears
                                as $schoolYear
                            )

                                <option
                                    value="{{
                                        $schoolYear->id
                                    }}"
                                    @selected(
                                        old(
                                            'school_year_id',
                                            $section
                                            ->school_year_id
                                            ?? ''
                                        )
                                        ==
                                        $schoolYear->id
                                    )
                                >
                                    {{
                                        $schoolYear
                                        ->name
                                    }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Grade Level
                        </label>

                        <select
                            name="grade_level_id"
                            class="form-select"
                        >

                            @foreach (
                                $gradeLevels
                                as $gradeLevel
                            )

                                <option
                                    value="{{
                                        $gradeLevel->id
                                    }}"
                                    @selected(
                                        old(
                                            'grade_level_id',
                                            $section
                                            ->grade_level_id
                                            ?? ''
                                        )
                                        ==
                                        $gradeLevel->id
                                    )
                                >
                                    {{
                                        $gradeLevel
                                        ->name
                                    }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Section Name
                        </label>

                        <input
                            name="name"
                            class="form-control"
                            placeholder="Rizal"
                            value="{{
                                old(
                                    'name',
                                    $section->name
                                    ?? ''
                                )
                            }}"
                        >

                    </div>


                    <div class="mb-4">

                        <label class="form-label">
                            Adviser
                        </label>

                        <select
                            name="adviser_teacher_id"
                            class="form-select"
                        >

                            <option value="">
                                — None —
                            </option>

                            @foreach (
                                $teachers
                                as $teacher
                            )

                                <option
                                    value="{{
                                        $teacher->id
                                    }}"
                                    @selected(
                                        old(
                                            'adviser_teacher_id',
                                            $section
                                            ->adviser_teacher_id
                                            ?? ''
                                        )
                                        ==
                                        $teacher->id
                                    )
                                >
                                    {{
                                        $teacher
                                        ->full_name
                                    }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    @if ($errors->any())

                        <div class="alert alert-danger">

                            @foreach (
                                $errors->all()
                                as $error
                            )
                                <div>
                                    {{ $error }}
                                </div>
                            @endforeach

                        </div>

                    @endif


                    <button class="btn btn-primary">
                        Save
                    </button>

                    <a
                        href="{{
                            route(
                                'admin.sections.index'
                            )
                        }}"
                        class="btn
                        btn-outline-secondary"
                    >
                        Cancel
                    </a>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection