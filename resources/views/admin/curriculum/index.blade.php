@extends('layouts.admin')

@section(
    'title',
    'Curriculum Blueprint'
)

@section(
    'page-title',
    'Curriculum Blueprint'
)

@section('content')

<div class="mb-4">

    <h2 class="page-title">
        Curriculum Blueprint
    </h2>

    <p class="text-muted">
        Define which subjects belong
        to every Elementary grade.
    </p>

</div>


<div class="row g-4">

@foreach (
    $gradeLevels
    as $gradeLevel
)

    <div class="col-lg-6">

        <div
            class="card
            dashboard-card h-100"
        >

            <div class="card-body">

                <div
                    class="d-flex
                    justify-content-between"
                >

                    <h4>
                        {{
                            $gradeLevel->name
                        }}
                    </h4>

                    <a
                        href="{{
                            route(
                                'admin.curriculum.edit',
                                $gradeLevel
                            )
                        }}"
                        class="btn
                        btn-sm
                        btn-outline-primary"
                    >
                        Configure
                    </a>

                </div>

                <hr>

                @forelse (
                    $gradeLevel->subjects
                    as $subject
                )

                    <span
                        class="badge
                        text-bg-light
                        border
                        me-1
                        mb-2"
                    >
                        {{
                            $subject->name
                        }}
                    </span>

                @empty

                    <p class="text-muted">
                        No subjects assigned.
                    </p>

                @endforelse

            </div>

        </div>

    </div>

@endforeach

</div>

@endsection