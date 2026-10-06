@extends('layouts.teacher')

@php
    $editing = isset($lesson);
@endphp

@section(
    'title',
    $editing
    ? 'Edit Lesson'
    : 'Add Lesson'
)

@section(
    'page-title',
    'Lesson'
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
            'teacher.lessons.update',
            [
                $classSubject,
                $lesson
            ]
        )
        : route(
            'teacher.lessons.store',
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
    Lesson Title
</label>

<input
    name="title"
    class="form-control"
    value="{{
        old(
            'title',
            $lesson->title
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
    rows="5"
>{{
    old(
        'description',
        $lesson->description
        ?? ''
    )
}}</textarea>

</div>


<div class="mb-3">

<label class="form-label">
    Learning Material
</label>

<input
    type="file"
    name="file"
    class="form-control"
>

</div>


<div class="mb-3">

<label class="form-label">
    Video URL
</label>

<input
    name="video_url"
    class="form-control"
    value="{{
        old(
            'video_url',
            $lesson->video_url
            ?? ''
        )
    }}"
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
            $lesson
            ->is_published
            ?? false
        )
    )
>

<label class="form-check-label">
    Publish lesson
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
    Save Lesson
</button>

<a
    href="{{
        route(
            'teacher.lessons.index',
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