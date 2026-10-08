<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Administrator') | K-12 LMS
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')

</head>

<body>


@php

    $displayName =
        auth()->user()->name
        ?? 'System Administrator';

    $parts =
        preg_split(
            '/\s+/',
            trim($displayName)
        );

    $initials = '';

    foreach(array_slice($parts, 0, 2) as $part) {

        if($part !== '') {

            $initials .=
                strtoupper(
                    mb_substr($part, 0, 1)
                );

        }

    }

    $initials =
        $initials ?: 'SA';

@endphp



<div class="app-shell">


    <aside
        id="sidebar"
        class="app-sidebar"
    >


        <div class="sidebar-brand">

            <div class="sidebar-logo">

                <i class="bi bi-book-fill"></i>

            </div>


            <div>

                <div class="sidebar-brand-title">
                    K-12 LMS
                </div>

                <div class="sidebar-brand-subtitle">
                    Elementary Administration
                </div>

            </div>

        </div>



        <nav class="sidebar-menu">


            <div class="sidebar-section-label">
                Overview
            </div>


            <a
                href="{{ route('admin.dashboard') }}"
                class="
                    sidebar-link
                    {{
                        request()->routeIs('admin.dashboard')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <i class="bi bi-grid-fill"></i>

                Dashboard

            </a>



            <div class="sidebar-section-label">
                Academic Setup
            </div>


            <a
                href="{{ route('admin.school-years.index') }}"
                class="
                    sidebar-link
                    {{
                        request()->routeIs('admin.school-years.*')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <i class="bi bi-calendar3"></i>

                School Years

            </a>


            <a
                href="{{ route('admin.grade-levels.index') }}"
                class="
                    sidebar-link
                    {{
                        request()->routeIs('admin.grade-levels.*')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <i class="bi bi-layers"></i>

                Grade Levels

            </a>


            <a
                href="{{ route('admin.sections.index') }}"
                class="
                    sidebar-link
                    {{
                        request()->routeIs('admin.sections.*')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <i class="bi bi-diagram-3"></i>

                Sections

            </a>


            <a
                href="{{ route('admin.subjects.index') }}"
                class="
                    sidebar-link
                    {{
                        request()->routeIs('admin.subjects.*')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <i class="bi bi-book"></i>

                Subjects

            </a>


            <a
                href="{{ route('admin.curriculum.index') }}"
                class="
                    sidebar-link
                    {{
                        request()->routeIs('admin.curriculum.*')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <i class="bi bi-file-earmark-text"></i>

                Curriculum Blueprint

            </a>



            <div class="sidebar-section-label">
                People
            </div>


            <a
                href="{{ route('admin.teachers.index') }}"
                class="
                    sidebar-link
                    {{
                        request()->routeIs('admin.teachers.*')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <i class="bi bi-person-badge"></i>

                Teachers

            </a>


            <a
                href="{{ route('admin.students.index') }}"
                class="
                    sidebar-link
                    {{
                        request()->routeIs('admin.students.*')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <i class="bi bi-people"></i>

                Students

            </a>



            <div class="sidebar-section-label">
                Enrollment
            </div>


            <a
                href="{{ route('admin.enrollments.index') }}"
                class="
                    sidebar-link
                    {{
                        request()->routeIs('admin.enrollments.*')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <i class="bi bi-person-plus"></i>

                Enrollments

            </a>


            <a
                href="{{ route('admin.class-assignments.index') }}"
                class="
                    sidebar-link
                    {{
                        request()->routeIs('admin.class-assignments.*')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <i class="bi bi-display"></i>

                Class Assignments

            </a>


        </nav>


    </aside>



    <div
        id="sidebarBackdrop"
        class="sidebar-backdrop"
    ></div>



    <main class="app-main">


        <header class="app-topbar">


            <div class="topbar-left">


                <button
                    id="sidebarToggle"
                    type="button"
                    class="sidebar-toggle"
                >

                    <i class="bi bi-list"></i>

                </button>



                <div class="global-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="search"
                        placeholder="Search anything..."
                    >

                </div>


            </div>



            <div class="topbar-right">


                <button
                    type="button"
                    class="notification-button"
                >

                    <i class="bi bi-bell"></i>

                    <span class="notification-dot"></span>

                </button>



                <div class="profile-avatar">
                    {{ $initials }}
                </div>



                <div class="profile-info">

                    <div class="profile-name">
                        {{ $displayName }}
                    </div>

                    <div class="profile-role">
                        Administrator
                    </div>

                </div>



                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="m-0"
                >

                    @csrf


                    <button
                        type="submit"
                        class="
                            btn
                            btn-outline-danger
                            logout-btn
                        "
                    >
                        Logout
                    </button>

                </form>


            </div>


        </header>



        <div class="app-content">


            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            @if($errors->any())

                <div class="alert alert-danger">

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            @yield('content')


        </div>


    </main>


</div>


@stack('scripts')

</body>
</html>