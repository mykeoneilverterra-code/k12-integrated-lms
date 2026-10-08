@extends('layouts.student')

@section('title', 'My Subjects')

@section('content')

@php

    $studentSubjects =
        collect(
            $subjects ??
            $mySubjects ??
            $classSubjects ??
            []
        );

@endphp


<div class="mb-4">

    <h1 class="fw-bold mb-1">
        My Subjects
    </h1>

    <p class="text-muted mb-0">
        View your subjects for the active school year.
    </p>

</div>


<section class="k12-panel">

    <div class="k12-panel-body p-3">


        @if ($studentSubjects->isNotEmpty())

            <div class="k12-subject-grid">


                @foreach ($studentSubjects as $classSubject)

                    @php

                        $subjectName =
                            $classSubject->subject->name ??
                            $classSubject->name ??
                            'Subject';

                        $grade =
                            $classSubject->section->gradeLevel->name ??
                            '';

                        $section =
                            $classSubject->section->name ??
                            '';

                        $teacher =
                            $classSubject->teacher->full_name ??
                            $classSubject->teacher->name ??
                            null;

                        $normalized =
                            strtolower($subjectName);

                        if (
                            str_contains(
                                $normalized,
                                'math'
                            )
                        ) {

                            $iconClass = 'math';
                            $icon = 'bi-calculator-fill';

                        } elseif (
                            str_contains(
                                $normalized,
                                'science'
                            )
                        ) {

                            $iconClass = 'science';
                            $icon = 'bi-flask-fill';

                        } elseif (
                            str_contains(
                                $normalized,
                                'filipino'
                            )
                        ) {

                            $iconClass = 'filipino';
                            $icon = 'bi-bookmark-fill';

                        } elseif (
                            str_contains(
                                $normalized,
                                'mapeh'
                            )
                        ) {

                            $iconClass = 'mapeh';
                            $icon = 'bi-palette-fill';

                        } else {

                            $iconClass = 'default';
                            $icon = 'bi-book-fill';

                        }

                    @endphp


                    <article class="k12-subject-card">


                        <div class="k12-subject-top">

                            <div
                                class="k12-subject-icon {{ $iconClass }}"
                            >

                                <i class="bi {{ $icon }}"></i>

                            </div>


                            <div>

                                <h3 class="k12-subject-name">

                                    {{ $subjectName }}

                                </h3>

                                <div class="k12-subject-section">

                                    {{ $grade }}

                                    @if ($section)

                                        - {{ $section }}

                                    @endif

                                </div>

                            </div>

                        </div>


                        <div class="k12-subject-teacher">

                            <i class="bi bi-person-fill me-1"></i>

                            Teacher:

                            <strong>

                                {{ $teacher ?: 'Not assigned' }}

                            </strong>

                        </div>


                        <a
                            href="{{ url('/student/subjects/' . $classSubject->id) }}"
                            class="k12-subject-button"
                        >

                            View Subject

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </article>

                @endforeach


            </div>


        @else

            <div class="k12-empty-state">

                <img
                    src="{{ asset('images/ui/decorations/decorative-learning.png') }}"
                    class="k12-empty-image"
                    alt=""
                >

                <h4>
                    No subjects yet
                </h4>

                <p>
                    Subjects connected to your current enrollment
                    will automatically appear here.
                </p>

            </div>

        @endif


    </div>

</section>

@endsection