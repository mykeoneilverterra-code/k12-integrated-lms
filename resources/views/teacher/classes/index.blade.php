@extends('layouts.teacher')

@section('title', 'My Classes')

@section('content')

@php

    $teacherClasses =
        collect(
            $myClasses ??
            $classes ??
            []
        );

@endphp


<div class="mb-4">

    <h1 class="fw-bold mb-1">
        My Classes
    </h1>

    <p class="text-muted mb-0">
        View and manage your assigned Elementary classes.
    </p>

</div>


<section class="k12-panel">

    <div class="k12-panel-header">

        <div>

            <h2 class="k12-panel-title">
                Assigned Classes
            </h2>

            <div class="k12-panel-subtitle">
                Subjects currently assigned to you
            </div>

        </div>

    </div>


    <div class="k12-panel-body">


        @forelse ($teacherClasses as $class)

            @php

                $subject =
                    $class->subject->name ??
                    $class->subject_name ??
                    'Subject';

                $grade =
                    $class->section->gradeLevel->name ??
                    '';

                $section =
                    $class->section->name ??
                    '';

                $students =
                    $class->section->enrollments_count ??
                    $class->students_count ??
                    0;

            @endphp


            <a
                href="{{ url('/teacher/classes/' . $class->id) }}"
                class="k12-class-row"
            >

                <div class="k12-class-icon">

                    <i class="bi bi-journal-text"></i>

                </div>


                <div class="k12-class-info">

                    <div class="k12-class-name">

                        {{ $subject }}

                    </div>

                    <div class="k12-class-meta">

                        {{ $grade }}

                        @if ($section)

                            - {{ $section }}

                        @endif

                    </div>

                </div>


                <div class="k12-class-count">

                    {{ $students }}

                    <small>
                        {{ $students == 1 ? 'student' : 'students' }}
                    </small>

                </div>


                <i class="bi bi-chevron-right ms-2"></i>

            </a>


        @empty

            <div class="k12-empty-state">

                <img
                    src="{{ asset('images/ui/decorations/decorative-learning.png') }}"
                    class="k12-empty-image"
                    alt=""
                >

                <h4>
                    No classes assigned yet
                </h4>

                <p>
                    Once the administrator assigns you to a
                    class subject, it will automatically appear here.
                </p>

            </div>

        @endforelse


    </div>

</section>

@endsection