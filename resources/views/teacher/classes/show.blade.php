@extends('layouts.teacher')

@section(
    'title',
    'Class Overview'
)

@section(
    'page-title',
    'Class'
)

@section('content')

@include(
    'teacher.classes._tabs'
)


<div class="row g-4">

    @php

        $stats = [
            [
                'label' => 'Students',
                'value' => $studentCount,
            ],

            [
                'label' => 'Lessons',
                'value' => $lessonCount,
            ],

            [
                'label' => 'Assignments',
                'value' => $assignmentCount,
            ],

            [
                'label' => 'Quizzes',
                'value' => $quizCount,
            ],
        ];

    @endphp


    @foreach ($stats as $stat)

        <div
            class="col-md-6 col-xl-3"
        >

            <div class="card stat-card">

                <div class="card-body">

                    <h2>
                        {{ $stat['value'] }}
                    </h2>

                    <span class="text-muted">
                        {{ $stat['label'] }}
                    </span>

                </div>

            </div>

        </div>

    @endforeach

</div>

@endsection