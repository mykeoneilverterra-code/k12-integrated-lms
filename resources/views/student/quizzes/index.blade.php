@extends('layouts.student')

@section('title', 'Quizzes')
@section('page-title', 'Quizzes')

@section('content')

@include(
    'student.subjects._tabs'
)

<h3 class="mb-4">
    Quizzes
</h3>


<div class="card table-card">

<table class="table table-hover align-middle">

<thead>

<tr>
    <th class="ps-4">Quiz</th>
    <th>Questions</th>
    <th>Status</th>
    <th>Score</th>
    <th class="text-end pe-4">
        Action
    </th>
</tr>

</thead>

<tbody>

@forelse($quizzes as $quiz)

@php
    $attempt =
        $attempts->get(
            $quiz->id
        );
@endphp

<tr>

<td class="ps-4 fw-semibold">
    {{ $quiz->title }}
</td>

<td>
    {{ $quiz->questions_count }}
</td>

<td>

@if($attempt?->status === 'submitted')

<span class="badge text-bg-success">
    Completed
</span>

@else

<span class="badge text-bg-warning">
    Not Taken
</span>

@endif

</td>

<td>

@if($attempt?->status === 'submitted')

{{ $attempt->score }}

@else

—

@endif

</td>

<td class="text-end pe-4">

@if($attempt?->status === 'submitted')

<a
    href="{{
        route(
            'student.quizzes.result',
            [
                $classSubject,
                $quiz
            ]
        )
    }}"
    class="btn btn-sm btn-outline-success"
>
    Result
</a>

@else

<a
    href="{{
        route(
            'student.quizzes.take',
            [
                $classSubject,
                $quiz
            ]
        )
    }}"
    class="btn btn-sm btn-primary"
>
    Take Quiz
</a>

@endif

</td>

</tr>

@empty

<tr>

<td
    colspan="5"
    class="text-center py-5 text-muted"
>
    No quizzes available.
</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection