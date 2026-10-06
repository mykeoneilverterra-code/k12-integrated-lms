@extends('layouts.admin')

@php
    $editing =
        isset($classAssignment);
@endphp

@section(
    'title',
    $editing
        ? 'Edit Class Assignment'
        : 'Add Class Assignment'
)

@section(
    'page-title',
    $editing
        ? 'Edit Class Assignment'
        : 'Add Class Assignment'
)

@section('content')

<div class="row justify-content-center">

<div class="col-xl-8">

<div class="card form-card">

<div class="card-body p-4">

<form
    method="POST"
    action="{{
        $editing
        ? route(
            'admin.class-assignments.update',
            $classAssignment
        )
        : route(
            'admin.class-assignments.store'
        )
    }}"
>

@csrf

@if ($editing)
    @method('PUT')
@endif


<div class="mb-3">

    <label class="form-label">
        Section
    </label>

    <select
        name="section_id"
        id="section_id"
        class="form-select"
    >

        @foreach (
            $sections
            as $section
        )

            <option
                value="{{
                    $section->id
                }}"
                data-grade-level="{{
                    $section
                    ->grade_level_id
                }}"
                @selected(
                    old(
                        'section_id',
                        $classAssignment
                        ->section_id
                        ?? ''
                    )
                    ==
                    $section->id
                )
            >
                {{
                    $section
                    ->gradeLevel
                    ->name
                }}
                -
                {{
                    $section->name
                }}
            </option>

        @endforeach

    </select>

</div>


<div class="mb-3">

    <label class="form-label">
        Subject
    </label>

    <select
        name="subject_id"
        id="subject_id"
        class="form-select"
    >

        @foreach (
            $subjects
            as $subject
        )

            <option
                value="{{
                    $subject->id
                }}"
                data-grades="{{
                    $subject
                    ->gradeLevels
                    ->pluck('id')
                    ->implode(',')
                }}"
                @selected(
                    old(
                        'subject_id',
                        $classAssignment
                        ->subject_id
                        ?? ''
                    )
                    ==
                    $subject->id
                )
            >
                {{
                    $subject->name
                }}
            </option>

        @endforeach

    </select>

</div>


<div class="mb-4">

    <label class="form-label">
        Teacher
    </label>

    <select
        name="teacher_id"
        class="form-select"
    >

        <option value="">
            — Not assigned —
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
                        'teacher_id',
                        $classAssignment
                        ->teacher_id
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
    Save Assignment
</button>

<a
    href="{{
        route(
            'admin.class-assignments.index'
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


@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    () => {

        const section =
            document.getElementById(
                'section_id'
            );

        const subject =
            document.getElementById(
                'subject_id'
            );

        function filterSubjects() {

            const selectedOption =
                section.options[
                    section.selectedIndex
                ];

            const gradeId =
                selectedOption
                ?.dataset
                ?.gradeLevel;

            [...subject.options]
                .forEach(option => {

                    const grades =
                        option.dataset
                        .grades
                        ?.split(',')
                        ?? [];

                    option.hidden =
                        !grades.includes(
                            String(
                                gradeId
                            )
                        );
                });
        }

        section.addEventListener(
            'change',
            filterSubjects
        );

        filterSubjects();

    }
);

</script>

@endpush