@extends('layouts.admin')

@php
    $editing =
        isset($enrollment);
@endphp

@section(
    'title',
    $editing
        ? 'Edit Enrollment'
        : 'Enroll Student'
)

@section(
    'page-title',
    $editing
        ? 'Edit Enrollment'
        : 'Enroll Student'
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
            'admin.enrollments.update',
            $enrollment
        )
        : route(
            'admin.enrollments.store'
        )
    }}"
>

@csrf

@if ($editing)
    @method('PUT')
@endif


<div class="mb-3">

    <label class="form-label">
        Student
    </label>

    <select
        name="student_id"
        class="form-select"
    >

        <option value="">
            Select student
        </option>

        @foreach (
            $students
            as $student
        )

            <option
                value="{{
                    $student->id
                }}"
                @selected(
                    old(
                        'student_id',
                        $enrollment
                        ->student_id
                        ?? ''
                    )
                    ==
                    $student->id
                )
            >
                {{
                    $student
                    ->student_number
                }}
                -
                {{
                    $student
                    ->full_name
                }}
            </option>

        @endforeach

    </select>

</div>


<div class="mb-3">

    <label class="form-label">
        School Year
    </label>

    <select
        name="school_year_id"
        id="school_year_id"
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
                        $enrollment
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
        Grade / Section
    </label>

    <select
        name="section_id"
        id="section_id"
        class="form-select"
    >

        <option value="">
            Select section
        </option>

        @foreach (
            $sections
            as $section
        )

            <option
                value="{{
                    $section->id
                }}"
                data-school-year="{{
                    $section
                    ->school_year_id
                }}"
                @selected(
                    old(
                        'section_id',
                        $enrollment
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


<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Enrollment Date
        </label>

        <input
            type="date"
            name="enrolled_at"
            class="form-control"
            value="{{
                old(
                    'enrolled_at',
                    isset($enrollment)
                    && $enrollment
                        ->enrolled_at
                    ? $enrollment
                        ->enrolled_at
                        ->format(
                            'Y-m-d'
                        )
                    : now()
                        ->format(
                            'Y-m-d'
                        )
                )
            }}"
        >

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Status
        </label>

        <select
            name="status"
            class="form-select"
        >

            @foreach (
                [
                    'enrolled',
                    'passed',
                    'retained',
                    'transferred',
                    'dropped'
                ]
                as $status
            )

                <option
                    value="{{ $status }}"
                    @selected(
                        old(
                            'status',
                            $enrollment
                            ->status
                            ?? 'enrolled'
                        )
                        === $status
                    )
                >
                    {{
                        ucfirst(
                            $status
                        )
                    }}
                </option>

            @endforeach

        </select>

    </div>

</div>


@if ($errors->any())

<div class="alert alert-danger">

@foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
@endforeach

</div>

@endif


<button class="btn btn-primary">
    Save Enrollment
</button>

<a
    href="{{
        route(
            'admin.enrollments.index'
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

        const schoolYear =
            document.getElementById(
                'school_year_id'
            );

        const section =
            document.getElementById(
                'section_id'
            );

        function filterSections() {

            const year =
                schoolYear.value;

            [...section.options]
                .forEach(option => {

                    if (!option.value) {
                        return;
                    }

                    option.hidden =
                        option.dataset
                            .schoolYear
                        !== year;
                });
        }

        schoolYear.addEventListener(
            'change',
            filterSections
        );

        filterSections();

    }
);

</script>

@endpush