@extends('layouts.teacher')

@php
    $editing = isset($quiz);
@endphp

@section(
    'title',
    $editing
    ? 'Edit Quiz'
    : 'Add Quiz'
)

@section(
    'page-title',
    'Quiz'
)

@section('content')

@include(
    'teacher.classes._tabs'
)


<div class="card form-card">

<div class="card-body p-4">

<form
    method="POST"
    action="{{
        $editing
        ? route(
            'teacher.quizzes.update',
            [
                $classSubject,
                $quiz
            ]
        )
        : route(
            'teacher.quizzes.store',
            $classSubject
        )
    }}"
>

@csrf

@if ($editing)
    @method('PUT')
@endif


<div class="mb-3">

<label class="form-label">
    Quiz Title
</label>

<input
    name="title"
    class="form-control"
    value="{{
        old(
            'title',
            $quiz->title
            ?? ''
        )
    }}"
>

</div>


<div class="mb-3">

<label class="form-label">
    Description
</label>

<textarea
    name="description"
    class="form-control"
    rows="4"
>{{
    old(
        'description',
        $quiz->description
        ?? ''
    )
}}</textarea>

</div>


<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">
    Duration (minutes)
</label>

<input
    type="number"
    name="duration_minutes"
    class="form-control"
    value="{{
        old(
            'duration_minutes',
            $quiz
            ->duration_minutes
            ?? ''
        )
    }}"
>

</div>


<div class="col-md-4 mb-3">

<label class="form-label">
    Opens At
</label>

<input
    type="datetime-local"
    name="opens_at"
    class="form-control"
    value="{{
        old(
            'opens_at',
            isset($quiz)
            && $quiz->opens_at
            ? $quiz
                ->opens_at
                ->format(
                    'Y-m-d\TH:i'
                )
            : ''
        )
    }}"
>

</div>


<div class="col-md-4 mb-3">

<label class="form-label">
    Closes At
</label>

<input
    type="datetime-local"
    name="closes_at"
    class="form-control"
    value="{{
        old(
            'closes_at',
            isset($quiz)
            && $quiz->closes_at
            ? $quiz
                ->closes_at
                ->format(
                    'Y-m-d\TH:i'
                )
            : ''
        )
    }}"
>

</div>

</div>


<div class="form-check mb-4">

<input
    type="checkbox"
    name="is_published"
    value="1"
    class="form-check-input"
    @checked(
        old(
            'is_published',
            $quiz
            ->is_published
            ?? false
        )
    )
>

<label class="form-check-label">
    Publish quiz
</label>

</div>


<button class="btn btn-primary">
    Save Quiz
</button>

</form>

</div>

</div>

@endsection