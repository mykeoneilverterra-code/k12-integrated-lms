@extends('layouts.student')

@section('title', 'Quiz Result')
@section('page-title', 'Quiz Result')

@section('content')

@include(
    'student.subjects._tabs'
)


<div class="card dashboard-card">

<div class="card-body text-center p-5">

<h2>
    {{ $quiz->title }}
</h2>

<p class="text-muted">
    Your Score
</p>

<h1 class="display-4 fw-bold">

{{ $attempt->score }}

/

{{ $totalPoints }}

</h1>

<p>

Submitted:

{{
    $attempt
        ->submitted_at
        ?->format(
            'M d, Y h:i A'
        )
}}

</p>

<a
    href="{{
        route(
            'student.quizzes.index',
            $classSubject
        )
    }}"
    class="btn btn-primary"
>
    Back to Quizzes
</a>

</div>

</div>

@endsection