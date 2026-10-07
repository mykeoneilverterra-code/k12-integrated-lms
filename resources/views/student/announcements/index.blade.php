@extends('layouts.student')

@section('title', 'Announcements')
@section('page-title', 'Announcements')

@section('content')

<h2 class="page-title mb-4">
    Announcements
</h2>


@forelse($announcements as $announcement)

<div class="card dashboard-card mb-3">

<div class="card-body">

<div
    class="d-flex
    justify-content-between"
>

<div>

<h5>
    {{ $announcement->title }}
</h5>

<small class="text-primary">

{{
    $announcement
        ->classSubject
        ->subject
        ->name
}}

</small>

</div>

<small class="text-muted">

{{
    $announcement
        ->published_at
        ?->format(
            'M d, Y h:i A'
        )
}}

</small>

</div>

<hr>

<p class="mb-0">
    {{ $announcement->body }}
</p>

</div>

</div>

@empty

<p class="text-muted">
    No announcements.
</p>

@endforelse

@endsection