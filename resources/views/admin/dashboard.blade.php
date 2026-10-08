@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

@php

    $studentTotal =
        $studentCount ??
        $studentsCount ??
        0;

    $teacherTotal =
        $teacherCount ??
        $teachersCount ??
        0;

    $gradeTotal =
        $gradeLevelCount ??
        $gradeLevelsCount ??
        6;

    $sectionTotal =
        $sectionCount ??
        $sectionsCount ??
        0;

@endphp


{{-- =========================================================
     ADMIN IMAGE BANNER
========================================================= --}}

<div class="k12-dashboard-banner">

    <img
        src="{{ asset('images/ui/banners/admin-banner.png') }}"
        alt="Welcome back Administrator"
    >

</div>


{{-- =========================================================
     STATS
========================================================= --}}

<div class="k12-stats-grid">

    <div class="k12-stat-card">

        <div class="k12-stat-icon blue">
            <i class="bi bi-people-fill"></i>
        </div>

        <div>

            <h2 class="k12-stat-value">
                {{ $studentTotal }}
            </h2>

            <div class="k12-stat-title">
                Students
            </div>

            <div class="k12-stat-subtitle">
                Total enrolled students
            </div>

        </div>

    </div>


    <div class="k12-stat-card">

        <div class="k12-stat-icon green">
            <i class="bi bi-person-fill"></i>
        </div>

        <div>

            <h2 class="k12-stat-value">
                {{ $teacherTotal }}
            </h2>

            <div class="k12-stat-title">
                Teachers
            </div>

            <div class="k12-stat-subtitle">
                Active teachers
            </div>

        </div>

    </div>


    <div class="k12-stat-card">

        <div class="k12-stat-icon yellow">
            <i class="bi bi-book-fill"></i>
        </div>

        <div>

            <h2 class="k12-stat-value">
                {{ $gradeTotal }}
            </h2>

            <div class="k12-stat-title">
                Grade Levels
            </div>

            <div class="k12-stat-subtitle">
                Elementary levels
            </div>

        </div>

    </div>


    <div class="k12-stat-card">

        <div class="k12-stat-icon red">
            <i class="bi bi-grid-3x3-gap-fill"></i>
        </div>

        <div>

            <h2 class="k12-stat-value">
                {{ $sectionTotal }}
            </h2>

            <div class="k12-stat-title">
                Sections
            </div>

            <div class="k12-stat-subtitle">
                Total sections
            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     LOWER AREA
========================================================= --}}

<div class="k12-dashboard-grid">

    {{-- ENROLLMENT --}}

    <section class="k12-panel">

        <div class="k12-panel-header">

            <div>

                <h2 class="k12-panel-title">
                    Enrollment per Grade Level
                </h2>

                <div class="k12-panel-subtitle">
                    Students enrolled in the active school year
                </div>

            </div>

        </div>


        <div class="k12-panel-body">

            <div style="height:300px;">

                <canvas id="enrollmentChart"></canvas>

            </div>

        </div>

    </section>


    {{-- QUICK OVERVIEW --}}

    <section class="k12-panel">

        <div class="k12-panel-header">

            <div>

                <h2 class="k12-panel-title">
                    Quick Overview
                </h2>

                <div class="k12-panel-subtitle">
                    Current Elementary system information
                </div>

            </div>

        </div>


        <div class="k12-panel-body">

            <div class="k12-quick-links">


                <a
                    href="{{ url('/admin/students') }}"
                    class="k12-quick-link"
                >

                    <div class="k12-quick-link-icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <div class="k12-quick-link-text">

                        <strong>
                            Student Records
                        </strong>

                        <small>
                            Manage student information
                        </small>

                    </div>

                    <i class="bi bi-chevron-right"></i>

                </a>


                <a
                    href="{{ url('/admin/teachers') }}"
                    class="k12-quick-link"
                >

                    <div class="k12-quick-link-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>

                    <div class="k12-quick-link-text">

                        <strong>
                            Teacher Records
                        </strong>

                        <small>
                            Manage teacher accounts
                        </small>

                    </div>

                    <i class="bi bi-chevron-right"></i>

                </a>


                <a
                    href="{{ url('/admin/enrollments') }}"
                    class="k12-quick-link"
                >

                    <div class="k12-quick-link-icon">
                        <i class="bi bi-person-plus"></i>
                    </div>

                    <div class="k12-quick-link-text">

                        <strong>
                            Enrollments
                        </strong>

                        <small>
                            Manage active enrollments
                        </small>

                    </div>

                    <i class="bi bi-chevron-right"></i>

                </a>

            </div>

        </div>

    </section>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas =
        document.getElementById('enrollmentChart');

    if (!canvas) {
        return;
    }

    const values = @json(
        $enrollmentCounts ??
        $gradeEnrollmentCounts ??
        [0, 0, 0, 0, 0, 0]
    );

    new Chart(
        canvas,
        {
            type: 'bar',

            data: {
                labels: [
                    'Grade 1',
                    'Grade 2',
                    'Grade 3',
                    'Grade 4',
                    'Grade 5',
                    'Grade 6'
                ],

                datasets: [
                    {
                        label: 'Students',
                        data: values,
                        backgroundColor:
                            'rgba(22, 119, 255, 0.68)',

                        borderRadius: 5
                    }
                ]
            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {

                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color:
                                'rgba(130,150,175,.16)'
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }

                }

            }

        }
    );

});

</script>

@endsection