@extends('layouts.student')

@section('title', 'Dashboard')
@section('page-title', 'Student Dashboard')

@section('content')

<div class="mb-4">

<h2 class="page-title">
    Student Dashboard
</h2>

<p class="text-muted">
    Welcome,
    {{ $student->full_name }}!
</p>

</div>


<div class="row g-4 mb-4">

<div class="col-md-3">

<div class="card stat-card">

<div class="card-body">

<h2>
    {{ $subjects->count() }}
</h2>

<span class="text-muted">
    My Subjects
</span>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card stat-card">

<div class="card-body">

<h2>
    {{
        $upcomingAssignments +
        $upcomingQuizzes
    }}
</h2>

<span class="text-muted">
    Upcoming Activities
</span>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card stat-card">

<div class="card-body">

<h2>
    {{ $completedActivities }}
</h2>

<span class="text-muted">
    Completed
</span>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card stat-card">

<div class="card-body">

<h2>
    {{
        $generalAverage
        ? number_format(
            $generalAverage,
            0
        )
        : '—'
    }}
</h2>

<span class="text-muted">
    Grade Average
</span>

</div>

</div>

</div>

</div>


<div class="card dashboard-card">

<div class="card-body">

<h4 class="mb-3">
    My Subjects
</h4>


<div class="row g-3">

@forelse($subjects as $subject)

<div class="col-md-6 col-xl-4">

<div class="border rounded p-3">

<h5>
    {{ $subject->subject->name }}
</h5>

<p class="text-muted mb-1">

{{
    $subject
        ->section
        ->gradeLevel
        ->name
}}

-

{{
    $subject
        ->section
        ->name
}}

</p>

<small>

Teacher:
{{
    $subject->teacher
        ?->full_name
    ?? 'Not assigned'
}}

</small>


<div class="mt-3">

<a
    href="{{
        route(
            'student.subjects.show',
            $subject
        )
    }}"
    class="btn btn-sm btn-primary"
>
    View Subject
</a>

</div>

</div>

</div>

@empty

<p class="text-muted">
    No subjects available.
</p>

@endforelse

</div>

</div>

</div>

@endsection