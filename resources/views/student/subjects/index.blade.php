@extends('layouts.student')

@section('title', 'My Subjects')
@section('page-title', 'My Subjects')

@section('content')

<h2 class="page-title mb-4">
    My Subjects
</h2>

<div class="row g-4">

@forelse($subjects as $classSubject)

<div class="col-md-6 col-xl-4">

<div class="card dashboard-card h-100">

<div class="card-body">

<h4>
    {{
        $classSubject
            ->subject
            ->name
    }}
</h4>

<p class="text-muted">

{{
    $classSubject
        ->section
        ->gradeLevel
        ->name
}}

-

{{
    $classSubject
        ->section
        ->name
}}

</p>

<p>

Teacher:

<strong>
{{
    $classSubject
        ->teacher
        ?->full_name
    ?? 'Not assigned'
}}
</strong>

</p>

<a
    href="{{
        route(
            'student.subjects.show',
            $classSubject
        )
    }}"
    class="btn btn-primary"
>
    View Subject
</a>

</div>

</div>

</div>

@empty

<p class="text-muted">
    No subjects found.
</p>

@endforelse

</div>

@endsection