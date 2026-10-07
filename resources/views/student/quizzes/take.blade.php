@extends('layouts.student')

@section('title', $quiz->title)
@section('page-title', 'Take Quiz')

@section('content')

@include(
    'student.subjects._tabs'
)


<div class="card dashboard-card">

<div class="card-body p-4">

<h2>
    {{ $quiz->title }}
</h2>

<p class="text-muted">
    {{ $quiz->description }}
</p>

<hr>


<form
    method="POST"
    action="{{
        route(
            'student.quizzes.submit',
            [
                $classSubject,
                $quiz
            ]
        )
    }}"
>

@csrf


@foreach($quiz->questions as $question)

<div class="border rounded p-3 mb-4">

<h5>

{{ $loop->iteration }}.

{{ $question->question_text }}

<span class="text-muted">
    ({{ $question->points }} pts)
</span>

</h5>


@foreach($question->choices as $choice)

<div class="form-check mt-2">

<input
    type="radio"
    class="form-check-input"
    name="answers[{{ $question->id }}]"
    value="{{ $choice->id }}"
    id="choice-{{ $choice->id }}"
>

<label
    class="form-check-label"
    for="choice-{{ $choice->id }}"
>
    {{ $choice->choice_text }}
</label>

</div>

@endforeach

</div>

@endforeach


<button
    class="btn btn-success"
    onclick="
        return confirm(
            'Submit your quiz?'
        )
    "
>
    Submit Quiz
</button>

</form>

</div>

</div>

@endsection