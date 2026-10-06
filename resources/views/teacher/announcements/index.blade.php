@extends('layouts.teacher')

@section(
    'title',
    'Announcements'
)

@section(
    'page-title',
    'Announcements'
)

@section('content')

@include(
    'teacher.classes._tabs'
)


<div
    class="d-flex
    justify-content-between
    mb-4"
>

<h3>
    Announcements
</h3>

<a
    href="{{
        route(
            'teacher.announcements.create',
            $classSubject
        )
    }}"
    class="btn btn-primary"
>
    New Announcement
</a>

</div>


@forelse (
    $announcements
    as $announcement
)

<div
    class="card
    dashboard-card
    mb-3"
>

<div class="card-body">

<h5>
    {{ $announcement->title }}
</h5>

<p>
    {{ $announcement->body }}
</p>

<small class="text-muted">

{{
    $announcement
    ->published_at
    ?->format(
        'M d, Y h:i A'
    )
    ?? 'Draft'
}}

</small>


<div class="mt-3">

<a
    href="{{
        route(
            'teacher.announcements.edit',
            [
                $classSubject,
                $announcement
            ]
        )
    }}"
    class="btn
    btn-sm
    btn-outline-primary"
>
    Edit
</a>

</div>

</div>

</div>

@empty

<p class="text-muted">
    No announcements yet.
</p>

@endforelse

@endsection