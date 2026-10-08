<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Teacher') | K-12 LMS
    </title>


    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>


@php

    $user = auth()->user();

    $teacherName =
        $user->name
        ?? 'Teacher';

    $teacherNameParts =
        preg_split(
            '/\s+/',
            trim($teacherName)
        );

    $teacherInitials = '';

    if (!empty($teacherNameParts)) {

        $teacherInitials =
            strtoupper(
                mb_substr(
                    $teacherNameParts[0],
                    0,
                    1
                )
            );

        if (count($teacherNameParts) > 1) {

            $teacherInitials .=
                strtoupper(
                    mb_substr(
                        end($teacherNameParts),
                        0,
                        1
                    )
                );

        }

    }

    if (!$teacherInitials) {
        $teacherInitials = 'TC';
    }

@endphp



<div class="k12-app">


    <div class="k12-sidebar-overlay"></div>



    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    <aside class="k12-sidebar">


        <div class="k12-sidebar-brand">


            <div class="k12-sidebar-logo">

                <i class="bi bi-book-fill"></i>

            </div>


            <div>

                <h2>
                    K-12 LMS
                </h2>

                <small>
                    Elementary Teacher
                </small>

            </div>


        </div>



        <div class="k12-sidebar-section">
            OVERVIEW
        </div>


        <a
            href="{{ url('/teacher/dashboard') }}"
            class="
                k12-sidebar-link
                {{ request()->is('teacher/dashboard') ? 'active' : '' }}
            "
        >

            <i class="bi bi-grid-fill"></i>

            <span>
                Dashboard
            </span>

        </a>



        <div class="k12-sidebar-section">
            TEACHING
        </div>


        <a
            href="{{ url('/teacher/classes') }}"
            class="
                k12-sidebar-link
                {{ request()->is('teacher/classes*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-journals"></i>

            <span>
                My Classes
            </span>

        </a>


        <a
            href="{{ url('/teacher/quizzes') }}"
            class="
                k12-sidebar-link
                {{ request()->is('teacher/quizzes*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-question-square"></i>

            <span>
                Quizzes
            </span>

        </a>


        <a
            href="{{ url('/teacher/assignments') }}"
            class="
                k12-sidebar-link
                {{ request()->is('teacher/assignments*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-clipboard-check"></i>

            <span>
                Assignments
            </span>

        </a>


        <a
            href="{{ url('/teacher/lessons') }}"
            class="
                k12-sidebar-link
                {{ request()->is('teacher/lessons*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-file-earmark-text"></i>

            <span>
                Lessons
            </span>

        </a>


        <a
            href="{{ url('/teacher/students') }}"
            class="
                k12-sidebar-link
                {{ request()->is('teacher/students*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-people"></i>

            <span>
                Students
            </span>

        </a>


        <a
            href="{{ url('/teacher/grades') }}"
            class="
                k12-sidebar-link
                {{ request()->is('teacher/grades*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-award"></i>

            <span>
                Grades
            </span>

        </a>


        <a
            href="{{ url('/teacher/attendance') }}"
            class="
                k12-sidebar-link
                {{ request()->is('teacher/attendance*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-calendar-check"></i>

            <span>
                Attendance
            </span>

        </a>


        <a
            href="{{ url('/teacher/announcements') }}"
            class="
                k12-sidebar-link
                {{ request()->is('teacher/announcements*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-megaphone"></i>

            <span>
                Announcements
            </span>

        </a>


    </aside>



    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <div class="k12-main">


        {{-- TOP BAR --}}

        <header class="k12-topbar">


            <div class="k12-topbar-left">


                <button
                    type="button"
                    class="k12-sidebar-toggle"
                    data-sidebar-toggle
                >

                    <i class="bi bi-list"></i>

                </button>


                <div class="k12-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        placeholder="Search anything..."
                    >

                </div>


            </div>



            <div class="k12-topbar-profile">


                <button
                    type="button"
                    class="k12-notification-button"
                >

                    <i class="bi bi-bell"></i>

                </button>


                <div class="k12-avatar">

                    {{ $teacherInitials }}

                </div>


                <div>

                    <div class="k12-profile-name">

                        {{ $teacherName }}

                    </div>

                    <div class="k12-profile-role">
                        Teacher
                    </div>

                </div>


                <form
                    method="POST"
                    action="{{ url('/logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="k12-logout-button"
                    >

                        <i class="bi bi-box-arrow-right"></i>

                        Logout

                    </button>

                </form>


            </div>


        </header>



        {{-- CONTENT --}}

        <main class="k12-content">


            @if (session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif



            @if (session('error'))

                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >

                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif



            @yield('content')


        </main>


    </div>


</div>


</body>

</html>