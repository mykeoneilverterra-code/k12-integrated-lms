@extends('layouts.admin')

@section(
    'title',
    'Dashboard'
)

@section(
    'page-title',
    'Admin Dashboard'
)

@section('content')


<div class="mb-4">

    <h2 class="page-title">
        Admin Dashboard
    </h2>

    <p class="text-muted">
        Welcome back,
        {{ auth()->user()->name }}.
    </p>

</div>


<div class="row g-4 mb-4">

    @php

        $cards = [
            [
                'count' => $studentCount,
                'label' => 'Students',
                'icon' => 'people',
                'class' => 'primary',
            ],

            [
                'count' => $teacherCount,
                'label' => 'Teachers',
                'icon' => 'person-workspace',
                'class' => 'success',
            ],

            [
                'count' => $gradeLevelCount,
                'label' => 'Grade Levels',
                'icon' => 'book',
                'class' => 'warning',
            ],

            [
                'count' => $sectionCount,
                'label' => 'Sections',
                'icon' => 'grid-3x3',
                'class' => 'danger',
            ],
        ];

    @endphp


    @foreach ($cards as $card)

        <div
            class="col-md-6 col-xl-3"
        >

            <div
                class="card stat-card h-100"
            >

                <div
                    class="card-body
                    d-flex
                    align-items-center
                    gap-3"
                >

                    <div
                        class="stat-icon
                        bg-{{ $card['class'] }}-subtle
                        text-{{ $card['class'] }}"
                    >

                        <i
                            class="bi
                            bi-{{ $card['icon'] }}"
                        ></i>

                    </div>

                    <div>

                        <h3 class="mb-0">
                            {{
                                $card['count']
                            }}
                        </h3>

                        <small class="text-muted">
                            {{
                                $card['label']
                            }}
                        </small>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>


<div class="card dashboard-card mb-4">

    <div class="card-body">

        <div
            class="d-flex
            justify-content-between
            align-items-center"
        >

            <div>

                <h5>
                    Active School Year
                </h5>

                @if ($activeSchoolYear)

                    <h3 class="mb-0">
                        {{
                            $activeSchoolYear->name
                        }}
                    </h3>

                @else

                    <p
                        class="text-muted mb-0"
                    >
                        No active school year.
                    </p>

                @endif

            </div>

            @if ($activeSchoolYear)

                <span
                    class="badge
                    text-bg-success"
                >
                    Active
                </span>

            @endif

        </div>

    </div>

</div>


<div class="row g-4">

    <div class="col-xl-7">

        <div
            class="card
            dashboard-card h-100"
        >

            <div class="card-body">

                <h5 class="mb-4">
                    Enrollment Overview
                </h5>

                <canvas
                    id="enrollmentChart"
                    height="120"
                ></canvas>

            </div>

        </div>

    </div>


    <div class="col-xl-5">

        <div
            class="card
            dashboard-card h-100"
        >

            <div class="card-body">

                <h5 class="mb-3">
                    Recent Enrollments
                </h5>

                @forelse (
                    $recentEnrollments
                    as $enrollment
                )

                    <div
                        class="border-bottom
                        py-2"
                    >

                        <div class="fw-semibold">
                            {{
                                $enrollment
                                ->student
                                ->full_name
                            }}
                        </div>

                        <small class="text-muted">

                            {{
                                $enrollment
                                ->section
                                ->gradeLevel
                                ->name
                            }}

                            -

                            {{
                                $enrollment
                                ->section
                                ->name
                            }}

                        </small>

                    </div>

                @empty

                    <p class="text-muted">
                        No enrollments yet.
                    </p>

                @endforelse

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

        const canvas =
            document.getElementById(
                'enrollmentChart'
            );

        if (!canvas) {
            return;
        }

        new Chart(
            canvas,
            {
                type: 'bar',

                data: {
                    labels:
                        @json(
                            $chartLabels
                        ),

                    datasets: [{
                        label: 'Students',

                        data:
                            @json(
                                $chartData
                            ),

                        borderWidth: 1,
                    }],
                },

                options: {
                    responsive: true,

                    plugins: {
                        legend: {
                            display: false,
                        },
                    },

                    scales: {
                        y: {
                            beginAtZero: true,

                            ticks: {
                                precision: 0,
                            },
                        },
                    },
                },
            }
        );

    }
);

</script>

@endpush