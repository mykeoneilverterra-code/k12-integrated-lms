@extends('layouts.student')


@section('title', 'Student Dashboard')


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | SUBJECT COLLECTION
    |--------------------------------------------------------------------------
    |
    | Only collect the variable when it is actually iterable.
    |
    */

    $studentSubjectsSource =
        $subjects
        ?? $mySubjects
        ?? $classSubjects
        ?? [];


    $studentSubjects =
        is_iterable($studentSubjectsSource)
            ? collect($studentSubjectsSource)
            : collect();


    /*
    |--------------------------------------------------------------------------
    | SCHOOL YEAR
    |--------------------------------------------------------------------------
    */

    $schoolYearText =
        data_get(
            $activeSchoolYear ?? null,
            'name'
        )
        ?? data_get(
            $activeSchoolYear ?? null,
            'school_year'
        )
        ?? '2026-2027';

@endphp



{{-- =========================================================
     STUDENT BANNER
========================================================= --}}

<section class="k12-dashboard-banner">


    {{-- Fallback.
         Ito ang makikita kapag hindi pa existing ang image.
    --}}

    <div class="k12-dashboard-banner-fallback">

        <small>
            STUDENT DASHBOARD
        </small>

        <h1>
            Welcome back!
        </h1>

        <p>
            Here are your subjects for school year
            {{ $schoolYearText }}.
        </p>

    </div>


    {{-- Actual generated banner image --}}

    <img
        src="{{ asset('images/ui/banners/student-banner.png') }}"
        alt=""
        onerror="this.remove();"
    >


</section>



{{-- =========================================================
     MY SUBJECTS
========================================================= --}}

<section class="k12-panel">


    <div class="k12-panel-header">


        <div>

            <h2 class="k12-panel-title">
                My Subjects
            </h2>

            <div class="k12-panel-subtitle">
                Subjects enrolled in the active school year
            </div>

        </div>


        <a
            href="{{ url('/student/subjects') }}"
            class="k12-panel-link"
        >

            View All

        </a>


    </div>



    <div class="k12-panel-body">


        @if ($studentSubjects->isNotEmpty())


            <div class="k12-subject-grid">


                @foreach ($studentSubjects as $classSubject)


                    @php

                        $classSubjectId =
                            data_get(
                                $classSubject,
                                'id'
                            );


                        $subjectName =
                            data_get(
                                $classSubject,
                                'subject.name'
                            )
                            ?? data_get(
                                $classSubject,
                                'name'
                            )
                            ?? 'Subject';


                        $gradeName =
                            data_get(
                                $classSubject,
                                'section.gradeLevel.name'
                            )
                            ?? data_get(
                                $classSubject,
                                'section.grade_level.name'
                            )
                            ?? '';


                        $sectionName =
                            data_get(
                                $classSubject,
                                'section.name'
                            )
                            ?? '';


                        $teacherName =
                            data_get(
                                $classSubject,
                                'teacher.full_name'
                            )
                            ?? data_get(
                                $classSubject,
                                'teacher.name'
                            )
                            ?? null;


                        /*
                        |--------------------------------------------------------------------------
                        | SUBJECT ICON
                        |--------------------------------------------------------------------------
                        */

                        $normalizedSubject =
                            strtolower(
                                $subjectName
                            );


                        $iconClass =
                            'default';

                        $icon =
                            'bi-book-fill';


                        if (
                            str_contains(
                                $normalizedSubject,
                                'math'
                            )
                        ) {

                            $iconClass =
                                'math';

                            $icon =
                                'bi-calculator-fill';

                        } elseif (
                            str_contains(
                                $normalizedSubject,
                                'science'
                            )
                        ) {

                            $iconClass =
                                'science';

                            $icon =
                                'bi-flask-fill';

                        } elseif (
                            str_contains(
                                $normalizedSubject,
                                'filipino'
                            )
                        ) {

                            $iconClass =
                                'filipino';

                            $icon =
                                'bi-bookmark-fill';

                        } elseif (
                            str_contains(
                                $normalizedSubject,
                                'mapeh'
                            )
                        ) {

                            $iconClass =
                                'mapeh';

                            $icon =
                                'bi-palette-fill';

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


                                    @if ($gradeName)

                                        {{ $gradeName }}

                                    @endif


                                    @if ($sectionName)

                                        @if ($gradeName)
                                            -
                                        @endif

                                        {{ $sectionName }}

                                    @endif


                                </div>


                            </div>


                        </div>



                        <div class="k12-subject-teacher">


                            <i class="bi bi-person-fill me-1"></i>

                            Teacher:

                            <strong>

                                {{ $teacherName ?: 'Not assigned' }}

                            </strong>


                        </div>



                        <a
                            href="{{ $classSubjectId ? url('/student/subjects/' . $classSubjectId) : '#' }}"
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
                    onerror="this.remove();"
                >


                <h4>
                    No subjects available
                </h4>


                <p>
                    Your subjects will automatically appear here
                    after your enrollment and class assignments
                    have been configured.
                </p>


            </div>


        @endif


    </div>


</section>


@endsection