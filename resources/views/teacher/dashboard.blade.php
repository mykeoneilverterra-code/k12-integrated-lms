@extends('layouts.teacher')

@section(
    'title',
    'Dashboard'
)

@section(
    'page-title',
    'Teacher Dashboard'
)

@section('content')

<div class="mb-4">

    <h2 class="page-title">
        Teacher Dashboard
    </h2>

    <p class="text-muted">
        Welcome,
        {{
            $teacher->full_name
        }}!
    </p>

</div>


<div class="row g-4 mb-4">

    <div class="col-md-4">

        <div class="card stat-card">

            <div class="card-body">

                <h2>
                    {{ $classes->count() }}
                </h2>

                <span class="text-muted">
                    My Classes
                </span>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card stat-card">

            <div class="card-body">

                <h2>
                    {{ $totalStudents }}
                </h2>

                <span class="text-muted">
                    Total Students
                </span>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card stat-card">

            <div class="card-body">

                <h2>
                    {{
                        $upcomingActivities
                    }}
                </h2>

                <span class="text-muted">
                    Upcoming Activities
                </span>

            </div>

        </div>

    </div>

</div>


<div class="card dashboard-card">

    <div class="card-body">

        <div
            class="d-flex
            justify-content-between
            align-items-center
            mb-3"
        >

            <h4 class="mb-0">
                My Classes
            </h4>

            <a
                href="{{
                    route(
                        'teacher.classes.index'
                    )
                }}"
            >
                View All
            </a>

        </div>


        <div class="row g-3">

            @forelse (
                $classes
                as $class
            )

                <div class="col-lg-6">

                    <div
                        class="border
                        rounded p-3"
                    >

                        <h5>

                            {{
                                $class
                                ->section
                                ->gradeLevel
                                ->name
                            }}

                            -

                            {{
                                $class
                                ->section
                                ->name
                            }}

                        </h5>


                        <p class="mb-1">

                            {{
                                $class
                                ->subject
                                ->name
                            }}

                        </p>


                        <small
                            class="text-muted"
                        >
                            {{
                                $class
                                ->students_count
                            }}
                            Students
                        </small>

                        <div class="mt-3">

                            <a
                                href="{{
                                    route(
                                        'teacher.classes.show',
                                        $class
                                    )
                                }}"
                                class="btn
                                btn-sm
                                btn-primary"
                            >
                                View Class
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <p class="text-muted">
                    No classes assigned.
                </p>

            @endforelse

        </div>

    </div>

</div>

@endsection