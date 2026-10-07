@extends('layouts.student')

@section('title', $lesson->title)
@section('page-title', 'Lesson')

@section('content')

@include(
    'student.subjects._tabs'
)


<div class="card dashboard-card">

<div class="card-body p-4">

<h2>
    {{ $lesson->title }}
</h2>

<p class="text-muted">

Published:

{{
    $lesson
        ->published_at
        ?->format(
            'M d, Y h:i A'
        )
}}

</p>

<hr>

<p style="white-space: pre-line;">
    {{ $lesson->description }}
</p>


@if($lesson->file_path)

<a
    href="{{
        asset(
            'storage/' .
            $lesson->file_path
        )
    }}"
    target="_blank"
    class="btn btn-primary"
>
    Open Learning Material
</a>

@endif


@if($lesson->video_url)

<a
    href="{{ $lesson->video_url }}"
    target="_blank"
    class="btn btn-outline-primary"
>
    Watch Video
</a>

@endif

</div>

</div>

@endsection