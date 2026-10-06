@extends('layouts.teacher')

@section('title', 'My Classes')
@section('page-title', 'My Classes')

@section('content')

<h2 class="page-title mb-4">
    My Classes
</h2>


<div class="row g-4">

@forelse ($classes as $class)

    <div class="col-md-6 col-xl-4">

        <div
            class="card
            dashboard-card h-100"
        >

            <div class="card-body">

                <h4>

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

                </h4>


                <p class="fw-semibold">

                    {{
                        $class
                        ->subject
                        ->name
                    }}

                </p>


                <p class="text-muted">

                    {{
                        $class
                        ->students_count
                    }}
                    Students

                </p>


                <a
                    href="{{
                        route(
                            'teacher.classes.show',
                            $class
                        )
                    }}"
                    class="btn btn-primary"
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

@endsection