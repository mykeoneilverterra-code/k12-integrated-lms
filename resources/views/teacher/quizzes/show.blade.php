@extends('layouts.teacher')

@section(
    'title',
    'Quiz Questions'
)

@section(
    'page-title',
    'Quiz Questions'
)

@section('content')

@include(
    'teacher.classes._tabs'
)


<div class="row g-4">

<div class="col-xl-7">

<div class="card dashboard-card">

<div class="card-body">

<h3>
    {{ $quiz->title }}
</h3>

<p class="text-muted">
    Total Points:
    {{ $quiz->total_points }}
</p>

<hr>


@forelse (
    $quiz->questions
    as $question
)

<div
    class="border
    rounded p-3 mb-3"
>

<div
    class="d-flex
    justify-content-between"
>

<strong>
    {{
        $loop->iteration
    }}.
    {{
        $question
        ->question_text
    }}
</strong>

<span>
    {{
        $question->points
    }}
    pt(s)
</span>

</div>


<ul class="mt-3 mb-2">

@foreach (
    $question->choices
    as $choice
)

<li>

{{ $choice->choice_text }}

@if ($choice->is_correct)

<span
    class="badge
    text-bg-success"
>
    Correct
</span>

@endif

</li>

@endforeach

</ul>


<form
    method="POST"
    action="{{
        route(
            'teacher.questions.destroy',
            [
                $classSubject,
                $quiz,
                $question
            ]
        )
    }}"
>

@csrf
@method('DELETE')

<button
    class="btn
    btn-sm
    btn-outline-danger"
>
    Delete Question
</button>

</form>

</div>

@empty

<p class="text-muted">
    No questions yet.
</p>

@endforelse

</div>

</div>

</div>


<div class="col-xl-5">

<div class="card form-card">

<div class="card-body">

<h4>
    Add Question
</h4>


<form
    method="POST"
    action="{{
        route(
            'teacher.questions.store',
            [
                $classSubject,
                $quiz
            ]
        )
    }}"
>

@csrf


<div class="mb-3">

<label class="form-label">
    Question
</label>

<textarea
    name="question_text"
    class="form-control"
    rows="3"
></textarea>

</div>


<input
    type="hidden"
    name="type"
    value="multiple_choice"
>


<div class="mb-3">

<label class="form-label">
    Points
</label>

<input
    type="number"
    step="0.5"
    name="points"
    value="1"
    class="form-control"
>

</div>


@for ($i = 0; $i < 4; $i++)

<div class="input-group mb-2">

<div class="input-group-text">

<input
    type="radio"
    name="correct_choice"
    value="{{ $i }}"
    @checked($i === 0)
>

</div>

<input
    name="choices[]"
    class="form-control"
    placeholder="Choice {{
        $i + 1
    }}"
>

</div>

@endfor


<button
    class="btn
    btn-primary mt-3"
>
    Add Question
</button>

</form>

</div>

</div>

</div>

</div>

@endsection