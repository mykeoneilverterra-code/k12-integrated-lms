@extends('layouts.teacher')

@php
    $editing =
        isset($announcement);
@endphp

@section(
    'title',
    $editing
    ? 'Edit Announcement'
    : 'New Announcement'
)

@section(
    'page-title',
    'Announcement'
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
            'teacher.announcements.update',
            [
                $classSubject,
                $announcement
            ]
        )
        : route(
            'teacher.announcements.store',
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
            $announcement->title
            ?? ''
        )
    }}"
>

</div>


<div class="mb-3">

<label class="form-label">
    Announcement
</label>

<textarea
    name="body"
    class="form-control"
    rows="6"
>{{
    old(
        'body',
        $announcement->body
        ?? ''
    )
}}</textarea>

</div>


<div class="mb-4">

<label class="form-label">
    Publish Date
</label>

<input
    type="datetime-local"
    name="published_at"
    class="form-control"
    value="{{
        old(
            'published_at',
            isset($announcement)
            &&
            $announcement
                ->published_at
            ? $announcement
                ->published_at
                ->format(
                    'Y-m-d\TH:i'
                )
            : now()
                ->format(
                    'Y-m-d\TH:i'
                )
        )
    }}"
>

</div>


<button class="btn btn-primary">
    Save Announcement
</button>

</form>

</div>

</div>

@endsection