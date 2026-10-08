@extends('layouts.teacher')


@section('title', 'Teacher Dashboard')


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | MY CLASSES
    |--------------------------------------------------------------------------
    |
    | Safe handling:
    | if controller sends Collection/array -> use it
    | if controller sends count/int -> do not foreach it
    |
    */

    $teacherClassesSource =
        $myClasses
        ?? $classes
        ?? [];

    $teacherClasses =
        is_iterable($teacherClassesSource)
            ? collect($teacherClassesSource)
            : collect();


    /*
    |--------------------------------------------------------------------------
    | CLASS COUNT
    |--------------------------------------------------------------------------
    */

    if (isset($myClassesCount) && is_numeric($myClassesCount)) {

        $classTotal =
            (int) $myClassesCount;

    } elseif (isset($classCount) && is_numeric($classCount)) {

        $classTotal =
            (int) $classCount;

    } elseif (
        isset($myClasses) &&
        is_numeric($myClasses)
    ) {

        $classTotal =
            (int) $myClasses;

    } else {

        $classTotal =
            $teacherClasses->count();

    }


    /*
    |--------------------------------------------------------------------------
    | STUDENT COUNT
    |--------------------------------------------------------------------------
    */

    $studentTotal = 0;

    if (
        isset($totalStudents) &&
        is_numeric($totalStudents)
    ) {

        $studentTotal =
            (int) $totalStudents;

    } elseif (
        isset($studentCount) &&
        is_numeric($studentCount)
    ) {

        $studentTotal =
            (int) $studentCount;

    }


    /*
    |--------------------------------------------------------------------------
    | UPCOMING ACTIVITIES
    |--------------------------------------------------------------------------
    |
    | Your current controller appears to send $upcomingActivities
    | as INTEGER, e.g. 2.
    |
    | Therefore:
    | - numeric = use as count
    | - iterable = use as actual activity list
    |
    */

    $activityItems =
        collect();

    $activityTotal = 0;


    if (isset($upcomingActivities)) {

        if (
            is_array($upcomingActivities) ||
            $upcomingActivities instanceof \Traversable
        ) {

            $activityItems =
                collect($upcomingActivities);

            $activityTotal =
                $activityItems->count();

        } elseif (
            is_numeric($upcomingActivities)
        ) {

            $activityTotal =
                (int) $upcomingActivities;

        }

    }


    if (
        isset($upcomingActivitiesCount) &&
        is_numeric($upcomingActivitiesCount)
    ) {

        $activityTotal =
            (int) $upcomingActivitiesCount;

    }


    if (
        isset($upcomingCount) &&
        is_numeric($upcomingCount)
    ) {

        $activityTotal =
            (int) $upcomingCount;

    }

@endphp



{{-- =========================================================
     TEACHER BANNER
========================================================= --}}

<section class="k12-dashboard-banner">


    <div class="k12-dashboard-banner-fallback">

        <small>
            TEACHER DASHBOARD
        </small>

        <h1>
            Welcome back, Teacher!
        </h1>

        <p>
            Here's an overview of your classes.
        </p>

    </div>


    <img
        src="{{ asset('images/ui/banners/teacher-banner.png') }}"
        alt=""
        onerror="this.remove();"
    >


</section>



{{-- =========================================================
     STATS
========================================================= --}}

<section class="k12-stats-grid three">


    <div class="k12-stat-card">


        <div class="k12-stat-icon blue">

            <i class="bi bi-people-fill"></i>

        </div>


        <div>

            <h2 class="k12-stat-value">

                {{ $classTotal }}

            </h2>

            <div class="k12-stat-title">
                My Classes
            </div>

            <div class="k12-stat-subtitle">
                Total classes assigned
            </div>

        </div>


    </div>



    <div class="k12-stat-card">


        <div class="k12-stat-icon green">

            <i class="bi bi-person-fill"></i>

        </div>


        <div>

            <h2 class="k12-stat-value">

                {{ $studentTotal }}

            </h2>

            <div class="k12-stat-title">
                Total Students
            </div>

            <div class="k12-stat-subtitle">
                Students across classes
            </div>

        </div>


    </div>



    <div class="k12-stat-card">


        <div class="k12-stat-icon yellow">

            <i class="bi bi-calendar-event-fill"></i>

        </div>


        <div>

            <h2 class="k12-stat-value">

                {{ $activityTotal }}

            </h2>

            <div class="k12-stat-title">
                Upcoming Activities
            </div>

            <div class="k12-stat-subtitle">
                Assignments and quizzes
            </div>

        </div>


    </div>


</section>



{{-- =========================================================
     LOWER DASHBOARD
========================================================= --}}

<section class="k12-teacher-grid">


    {{-- MY CLASSES --}}

    <div class="k12-panel">


        <div class="k12-panel-header">


            <div>

                <h2 class="k12-panel-title">
                    My Classes
                </h2>

                <div class="k12-panel-subtitle">
                    Your currently assigned classes
                </div>

            </div>


            <a
                href="{{ url('/teacher/classes') }}"
                class="k12-panel-link"
            >

                View All

            </a>


        </div>



        <div class="k12-panel-body">


            @if ($teacherClasses->isNotEmpty())


                <div class="k12-class-list">


                    @foreach ($teacherClasses as $class)


                        @php

                            $classId =
                                data_get(
                                    $class,
                                    'id'
                                );


                            $subjectName =
                                data_get(
                                    $class,
                                    'subject.name'
                                )
                                ?? data_get(
                                    $class,
                                    'subject_name'
                                )
                                ?? 'Subject';


                            $gradeName =
                                data_get(
                                    $class,
                                    'section.gradeLevel.name'
                                )
                                ?? data_get(
                                    $class,
                                    'section.grade_level.name'
                                )
                                ?? '';


                            $sectionName =
                                data_get(
                                    $class,
                                    'section.name'
                                )
                                ?? '';


                            $classStudents =
                                data_get(
                                    $class,
                                    'students_count'
                                )
                                ?? data_get(
                                    $class,
                                    'section.enrollments_count'
                                )
                                ?? 0;

                        @endphp



                        <a
                            href="{{ $classId ? url('/teacher/classes/' . $classId) : '#' }}"
                            class="k12-class-row"
                        >


                            <div class="k12-class-icon">

                                <i class="bi bi-calculator"></i>

                            </div>



                            <div class="k12-class-info">


                                <div class="k12-class-name">

                                    {{ $subjectName }}

                                </div>


                                <div class="k12-class-meta">

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



                            <div class="k12-class-count">

                                {{ $classStudents }}

                                <small>

                                    {{ $classStudents == 1 ? 'student' : 'students' }}

                                </small>

                            </div>


                        </a>


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
                        No classes assigned yet
                    </h4>


                    <p>
                        Classes assigned by the administrator
                        will automatically appear here.
                    </p>


                </div>


            @endif


        </div>


    </div>



    {{-- UPCOMING ACTIVITIES --}}

    <div class="k12-panel">


        <div class="k12-panel-header">


            <div>

                <h2 class="k12-panel-title">
                    Upcoming Activities
                </h2>

                <div class="k12-panel-subtitle">
                    Assignments and quizzes
                </div>

            </div>


        </div>



        <div class="k12-panel-body">


            {{-- IMPORTANT:
                 Only loop if we really have iterable activity records.
            --}}

            @if ($activityItems->isNotEmpty())


                <div class="k12-class-list">


                    @foreach ($activityItems as $activity)


                        @php

                            $activityTitle =
                                data_get(
                                    $activity,
                                    'title'
                                )
                                ?? 'Activity';


                            $activityDate =
                                data_get(
                                    $activity,
                                    'due_at'
                                )
                                ?? data_get(
                                    $activity,
                                    'due_date'
                                )
                                ?? data_get(
                                    $activity,
                                    'start_at'
                                )
                                ?? null;

                        @endphp



                        <div class="k12-class-row">


                            <div class="k12-class-icon">

                                <i class="bi bi-calendar-event"></i>

                            </div>


                            <div class="k12-class-info">


                                <div class="k12-class-name">

                                    {{ $activityTitle }}

                                </div>


                                <div class="k12-class-meta">

                                    @if ($activityDate)

                                        {{ $activityDate }}

                                    @else

                                        Upcoming activity

                                    @endif

                                </div>


                            </div>


                        </div>


                    @endforeach


                </div>


            @else


                <div class="k12-empty-state">


                    <i
                        class="bi bi-calendar-check"
                        style="
                            font-size:34px;
                            margin-bottom:12px;
                            color:#96afd0;
                        "
                    ></i>


                    @if ($activityTotal > 0)


                        <h4>
                            {{ $activityTotal }}
                            upcoming
                            {{ $activityTotal == 1 ? 'activity' : 'activities' }}
                        </h4>


                        <p>
                            The dashboard received the activity count,
                            but no detailed activity collection was
                            provided by the controller.
                        </p>


                    @else


                        <h4>
                            No upcoming activities
                        </h4>


                        <p>
                            Upcoming assignments and quizzes
                            will appear here.
                        </p>


                    @endif


                </div>


            @endif


        </div>


    </div>


</section>


@endsection