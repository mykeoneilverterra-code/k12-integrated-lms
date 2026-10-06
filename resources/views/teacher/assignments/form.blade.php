@extends('layouts.teacher')

@php
    $editing =
        isset($assignment);
@endphp

@section(
    'title',
    $editing
    ? 'Edit Assignment'
    : 'Add Assignment'
)

@section(
    'page-title',
    'Assignment'
)

@section('content')

@include(
    'teacher.classes._tabs'
)

<div class="card form-card">

<div class="card-body p-4">

<form
    method="POST"
    enctype="multipart/form-data"
    action="{{
        $editing
        ? route(
            'teacher.assignments.update',
            [
                $classSubject,
                $assignment
            ]
        )
        : route(
            'teacher.assignments.store',
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
    Title
</label>

<input
    name="title"
    class="form-control"
    value="{{
        old(
            'title',
            $assignment->title
            ?? ''
        )
    }}"
>

</div>


<div class="mb-3">

<label class="form-label">
    Instructions
</label>

<textarea
    name="instructions"
    class="form-control"
    rows="5"
>{{
    old(
        'instructions',
        $assignment
        ->instructions
        ?? ''
    )
}}</textarea>

</div>


<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
    Total Points
</label>

<input
    type="number"
    step="0.01"
    name="total_points"
    class="form-control"
    value="{{
        old(
            'total_points',
            $assignment
            ->total_points
            ?? 100
        )
    }}"
>

</div>


<div class="col-md-6 mb-3">

<label class="form-label">
    Due Date
</label>

<input
    type="datetime-local"
    name="due_at"
    class="form-control"
    value="{{
        old(
            'due_at',
            isset($assignment)
            && $assignment->due_at
            ? $assignment
                ->due_at
                ->format(
                    'Y-m-d\TH:i'
                )
            : ''
        )
    }}"
>

</div>

</div>


<div class="mb-3">

<label class="form-label">
    Attachment
</label>

<input
    type="file"
    name="attachment"
    class="form-control"
>

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
            $assignment
            ->is_published
            ?? false
        )
    )
>

<label class="form-check-label">
    Publish assignment
</label>

</div>


@if ($errors->any())

<div class="alert alert-danger">

@foreach ($errors->all() as $error)
<div>{{ $error }}</div>
@endforeach

</div>

@endif


<button class="btn btn-primary">
    Save Assignment
</button>

<a
    href="{{
        route(
            'teacher.assignments.index',
            $classSubject
        )
    }}"
    class="btn
    btn-outline-secondary"
>
    Cancel
</a>

</form>

</div>

</div>

@endsection